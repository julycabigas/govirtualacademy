<template>
	<div class="inner-info pt-5">
		<!-- Start of Breadcrumb -->
		<div class="breadcrumb mb-3">
	
				<ul class="list-unstyled">
					<li><router-link to="/my-profile/dashboard">My Profile</router-link></li>
					<li><span>Edit Your Profile</span></li>
				</ul>

		</div>
		<!-- End of Breadcrumb -->
				
		<!-- Start Form -->
		<form @submit.prevent="update" class="pt-4">
			<table class="table table-striped">
				<tr>
					<td width="300">Photo</td>
					<td>
						<div v-if="student.image" class="profile-photo mb-4">
							<img :src="`/users/${student.image}`" width="200" height="auto" />
						</div>
						
						<input type="file" @change="onFileSelected">
					</td>
				</tr>
				<tr>
					<td>First Name</td>
					<td><input type="text" v-model="student.firstname"></td>
				</tr>
				<tr>
					<td>Last Name</td>
					<td><input type="text" v-model="student.lastname"></td>
				</tr>
				<tr v-if="userRole == 8">
					<td>Position</td>
					<td><input type="text" v-model="student.position"></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><input type="text" v-model="student.email"></td>
				</tr>
				<tr>
					<td>Address 1</td>
					<td><input type="text" v-model="student.address"></td>
				</tr>
				<tr>
					<td>Address 2</td>
					<td><input type="text" v-model="student.address_2"></td>
				</tr>
				<tr>
					<td>Zipcode</td>
					<td><input type="text" v-model="student.zipcode"></td>
				</tr>
				<tr>
					<td>Municipality</td>
					<td><input type="text" v-model="student.municipality"></td>
				</tr>
				<tr>
					<td>Phone No. / Mobile No.</td>
					<td><input type="text" v-model="student.phone"></td>
				</tr>
				<tr>
					<td>About Me</td>
					<td>
						<vue-editor v-model="student.about"></vue-editor>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Save Changes" class="btn btn-primary" ></td>
				</tr>
			</table>
		</form>
		<!-- End Form -->

		
		
		
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
					position: '',
					role: 6
				},
				image: ''
			}
		},
		created() {

			this.getStudentInfo();
		},
		methods: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			getStudentInfo() {
				axios.get(`/api/students/${this.currentUserID}`,  {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
					.then((response) => {
			
						this.student = response.data.student;
					},
					)
					.catch((error) => {
						console.log(error);
					})
			},
			update() {
				axios.post(`/api/students/update/${this.currentUserID}`, { 
					  'image'	: this.image,
					  'student' :this.$data.student 
				    }, {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
					.then((response) => {
						this.student = response.data.student;

						if(this.userRole == 8) {
							this.$router.push('/mentor');
						}
						else {
							this.$router.push('/my-profile/dashboard');
						}
						
					})
					.catch((error) => {
						console.log(error);
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
            }
		},
		computed: {
			currentUserID() {
				return this.$store.getters.currentUser.id;
			},
			currentUserToken() {
				return this.$store.getters.currentUser.token;
			},
			userRole() {
				return this.$store.getters.currentUser.role;
			}
		}
	}
</script>
