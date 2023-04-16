<template>
	<div class="inner-info">
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
					<th>First Name</th>
					<td><input type="text" v-model="student.firstname" class="form-control"></td>
				</tr>
				<tr>
					<th>Last Name</th>
					<td><input type="text" v-model="student.lastname" class="form-control"></td>
				</tr>
				<tr>
					<th>Job Title</th>
					<td><input type="text" v-model="student.position" class="form-control"></td>
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
					<th>Show Profile in Public</th>
					<td>

							<input type="checkbox" v-model="student.show_profile"  /> Tick to show profile
				
					</td>
				</tr> 
				<tr>
					<th>About Me</th>
					<td>
						<vue-editor v-model="student.about"></vue-editor>
					</td>
				</tr>

				<tr>
					<th></th>
					<td><input type="submit" value="Save Changes" class="btn btn-primary" ></td>
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
					image: ''
					
				},
				limit: '',
				checkRoles: [],
				allAccess: [],
				identifiers: [],
				trialGroup: '',
				image: ''
			}
		},
		mounted() {
			this.$store.dispatch('getRoles');
			
		},
		created() {
			this.getStudentInfo();
		},
		methods: {

			getStudentInfo() {
				axios.get(`/api/mentor-single/${this.$route.params.id}`)
					.then((response) => {
						this.student = response.data.mentor;
					})
					.catch((error) => {
						console.log(error);
					})
			},
			update() {


				axios.post(`/api/mentors/update/${this.$route.params.id}`, { 
					'student': this.$data.student,
					'image'	: this.image
				}, {
					headers: {
						"Authorization": `Bearer ${this.currentUserToken}`
					}
				})
				.then((response) => {
					this.student = response.data.student;
					this.$router.push('/admin/mentors');
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
			currentUserToken() {
				return this.$store.getters.currentUser.token;
			},
			roles() {
				return this.$store.getters.roles;
			}
		}
	}
</script>