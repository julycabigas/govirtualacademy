<template>
	<div class="inner-info">
		<div class="col-sm-12 text-right show-profile" v-if="student">
			<span>Show Profile</span> <toggle-button :value="privacy" @change="onPrivacySwitch"/>
		</div>
		<form @submit.prevent="update">
			<table class="table table-striped">
				<tr>
					<th width="300">Photo</th>
					<td>
						<div v-if="student.image" class="profile-photo mb-4">
							<img :src="`/users/${student.image}`" width="200" height="auto" />
						</div>
						
						<input type="file" @change="onFileSelected">
					</td>
				</tr>
				<tr>
					<th>Password</th>
					<td><input type="password" v-model="password" class="form-control"></td>
				</tr>
				<tr>
					<th>First Name</th>
					<td><input type="text" v-model="student.firstname" class="form-control"></td>
				</tr>
				<tr>
					<th>Last Name</th>
					<td><input type="text" v-model="student.lastname" class="form-control"></td>
				</tr>
				<tr>
					<th>Email</th>
					<td><input type="text" v-model="student.email" class="form-control"></td>
				</tr>
				<tr>
					<th>Address 1</th>
					<td><input type="text" v-model="student.address" class="form-control"></td>
				</tr>
				<tr>
					<th>Address 2</th>
					<td><input type="text" v-model="student.address_2" class="form-control"></td>
				</tr>
				<tr>
					<th>Zipcode</th>
					<td><input type="text" v-model="student.zipcode" class="form-control"></td>
				</tr>
				<tr>
					<th>Municipality</th>
					<td><input type="text" v-model="student.municipality" class="form-control"></td>
				</tr>
				<tr>
					<th>Phone No. / Mobile No.</th>
					<td>
						<input type="text" v-model="student.phone" class="form-control">
					</td>
				</tr>
				<tr>
					<th>About Me</th>
					<td>
						<vue-editor v-model="student.about"></vue-editor>
					</td>
				</tr>
				 <tr>
					<th>Free Trial</th>
					<td>
						Course Group : 
						<div v-for="group in identifiers" :key="group.id">
							<input type="radio" v-model="trialGroup" :value="group.id" /> {{ group.name }}
						</div>
						<div class="mt-2">Step limit :  <input type="number" v-model="limit" class="form-control"></div>
					</td>
				</tr> 
				<tr>
					<th>Access Levels</th>
					<td>
						<div v-for="access in allAccess" :key="access.id">
							<input type="checkbox" v-model="checkRoles" :value="access.id" /> {{ access.display_name }}
						</div>
					</td>
				</tr>
				<tr>
					<th></th>
					<td><input type="submit" value="Update" class="btn btn-primary" ></td>
				</tr>
			</table>
		</form>
	</div>
</template>
<script>
	import { VueEditor } from 'vue2-editor';
	export default {
		name: 'edit-profile',
		components: {
			VueEditor
		},
		data() {
			return {
				student: {
					name: '',
					firstname: '',
					lastname: '',
					email: '',
					address: '',
					address_2: '',
					zipcode: '',
					municipality: '',
					about: '',
					phone: '',
					role: '',
					status: '',
					trials: {},
					show_profile: false,
					
				},
				limit: '',
				checkRoles: [],
				allAccess: [],
				identifiers: [],
				trialGroup: '',
				image: '',
				privacy: false,
				password: ''
			}
		},
		mounted() {
			this.$store.dispatch('getRoles');
			
		},
		created() {
			this.getStudentInfo();
			this.getAccessLevels();
			this.getStudentAccess();
			this.getAllCourseIdentifiers();
		},
		methods: {

			getStudentInfo() {
				axios.get(`/api/students/${this.$route.params.id}`)
					.then((response) => {
			
						if(response.data.student.show_profile == '1') {
							this.privacy = true;
						}

						this.student = response.data.student;
						this.trialGroup = response.data.student.trials.group_id;
						this.limit = response.data.student.trials.step_limit;
						
						
						
					})
					.catch((error) => {
						console.log(error);
					})
			},
			update() {

				axios.post(`/api/student-access/update/${this.$route.params.id}`, {
					'role' :  this.$data.checkRoles
				}, {
					headers: {
						"Authorization": `Bearer ${this.currentUserToken}`
					}
				})
				.then((response) => {
				});

				axios.post(`/api/student-info/update/${this.$route.params.id}`, { 
					'student': this.$data.student,
					'trialGroup' : this.$data.trialGroup,
					'limit' : this.$data.limit ,
					'image'	: this.image,
					'password' : this.password
				}, {
					headers: {
						"Authorization": `Bearer ${this.currentUserToken}`
					}
				})
				.then((response) => {
					console.log(response.data);
					this.student = response.data.student;
					this.$router.push('/admin/students');
				})
				.catch((error) => {
					console.log(error);
				})
			},
			getAllCourseIdentifiers() {
					axios.get(`/api/all-course-identifiers-list`, {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
					.then((response) => {
						   this.identifiers  = response.data.courses_identifiers;
					})
					.catch((error) => {
					  	  console.log(error);
					});
			},
			getAccessLevels() {
				axios.get(`/api/check-student-access`, {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
				 .then((response) => {
					 	console.log(response.data);
						this.allAccess = response.data.access_levels;
				 	 
				 })	
			},
			getStudentAccess() {
				axios.get(`/api/student-access/${this.$route.params.id}`)
				 .then((response) => {
				
				 	  for(let x = 0; x < response.data.access.length; x++) {
				 	  	  this.checkRoles[x] = response.data.access[x]['access_id'];
				 	  }
				 	 
				 })
			},
			onFileSelected(e) {
				let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
			},
			createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
			},
			onPrivacySwitch() {
				this.$data.privacy = !this.$data.privacy;

				axios.post(`/api/students/update-privacy/${this.$data.student.id}`, { 'privacy' : this.$data.privacy }
					, {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
					.then((response) => {

						this.privacy = response.data.privacy;
						alert('Privacy has been succesfully updated');
					})
					.catch((error) => {
						console.log(error);
					})
			}
		},
		computed: {
			currentUserToken() {
				return this.$store.getters.currentUser.token;
			},
			roles() {
				return this.$store.getters.roles;
			},
			currentUserID() {
				return this.$store.getters.currentUser.id;
			},
		}
	}
</script>