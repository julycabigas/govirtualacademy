<template>
	<div>
		<form @submit.prevent="add">
				
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="firtname">First Name</label>
						<input id="firtname" type="text" v-model="student.firstname" class="form-control">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="name">Last Name</label>
						<input id="name" type="text" v-model="student.lastname" class="form-control">
					</div>
				</div>
			</div>	
			
			<div class="form-group">
				<label for="email">Email</label>
				<input id="email" type="text" v-model="student.email" class="form-control">
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input id="password" type="password" v-model="student.password" class="form-control">
				<input type="hidden" v-model="student.role" value="2">
			</div>


			<div class="form-group">
				<label for="address">Address</label>
				<input id="address" type="text" v-model="student.address" class="form-control">
			</div>

			<div class="form-group">
				<label for="address2">Address 2</label>
				<input id="address2" type="text" v-model="student.address_2" class="form-control">
			</div>


			<div class="form-group">
				<label for="zipcode">Zipcode</label>
				<input id="zipcode" type="text" v-model="student.zipcode" class="form-control">
			</div>

			<div class="form-group">
				<label for="municipality">Municipality</label>
				<input id="municipality" type="text" v-model="student.municipality" class="form-control">

			</div>

			<div class="form-group">
				<label for="phone">Phone No. / Mobile No.</label>
				<input id="phone" type="text" v-model="student.phone" class="form-control">
			</div>

			<div class="form-group">
				Access Levels
				<div v-for="access in allAccess" :key="access.id">
					<input type="checkbox" v-model="checkRoles" :value="access.id" /> {{ access.display_name }}
				</div>
			</div>

			<input type="submit" value="Submit" class="btn btn-primary">

			<div class="errors" v-if="errors">
				<ul>
					<li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
						<strong>{{ fieldName }}</strong> {{ fieldsError.join('\n') }}
					</li>
				</ul>
			</div>

		</form>
	</div>
</template>
<script>
	import validate from 'validate.js';

	export default {
		name: 'new',
		data() {
			return  {
				student: {
					name: '',
					email: '',
					password: '',
					firstname: '',
					lastname: '',
					address: '',
					address_2: '',
					zipcode: '',
					municipality: '',
					phone: '',
				},
				errors: null,
				allAccess: [],
				checkRoles: [],
				student_id: ''
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		mounted() {
			this.getAccessLevels();
		},
		methods: {
			add() {
				this.errors = null;

				const constraints = this.getConstraints();

				const errors = validate(this.$data.student, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}
				 axios.post('/api/students/new', this.$data.student, {
					 	headers: {
							"Authorization": `Bearer ${this.currentUser.token}`
						}
				 	})
				 .then((response) => {
				 	this.student_id = response.data.student.id;
				
				 	axios.post(`/api/student-access/update/${this.student_id}`, 
			 				{'role' :  this.$data.checkRoles}, 
			 				{headers: {"Authorization": `Bearer ${this.currentUser.token}`}
						})
						.then((response) => {
							    this.$router.push('/admin/students');
								console.log(response.data);
						});
					//this.$router.push({ name: 'student-list', params: { message: 'Successfully added new student' } })
				 })
				 .catch((error) => {
						console.log(error);
				});

			 	// if(this.student_id) {
			 	// 	axios.post(`/api/student-access/update/${this.student_id}`, 
			 	// 			{'role' :  this.$data.checkRoles}, 
			 	// 			{headers: {"Authorization": `Bearer ${this.currentUser.tocken}`}
					// 	})
					// 	.then((response) => {
					// 		    this.$router.push('/admin/students');
					// 			console.log(response.data);
					// 	});
			 	// }
			},
			getAccessLevels() {
				axios.get(`/api/access-list/`, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				 .then((response) => {
				
						this.allAccess = response.data.access_levels;
				 	 
				 })	
			},
			getConstraints() 
			{
				return  {
					firstname: {
						presence: true, 
						length: {
							minimum: 3,
							message: 'Must be at least 3 characters long'
						}
					},
					email: {
                        presence: true, 
						 email: {
						      message: "doesn't look like a valid email"
						 }
					},
					password: {
						presence: true, 
						length: {
							minimum: 5,
							message: 'Must be at least 5 characters long'
						}
					},
				}
			}	
		}

	}
</script>