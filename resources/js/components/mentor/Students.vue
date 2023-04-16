<template>
	<div class="inner-info profile-content">
		<div id="loader-front" v-if="loading">
 			<div class="loading">
			    <Preloader />
			</div>
 		</div>
		<div class="row pt-3">
			<div class="col-lg-3 col-md-4">

				<div class="sidebar">
					<div class="mb-2">
						<div class="profile-upper-info">
							<div class="row">
								<div class="col-sm-6">
								</div>
								<div class="col-sm-6 text-right">
									<router-link to="/my-profile/edit">Edit</router-link>
								</div>
							</div>
						</div>
					</div>
					<div class="profile-main-info"> 
						<!-- Start of profile pic -->
						<div class="profile-pic">
							<template v-if="student.image != null">
							  <img :src="`/users/${student.image}`" width="120" height="auto" /> 
						    </template>
						    <template v-else>
							  <img :src="'/images/user_image.png'" width="120" height="auto" /> 
						    </template>
						</div>
						<!-- End of profile pic -->
						<!-- User Info -->
						<div class="user-top-info">
							<h3>{{ student.firstname }} {{ student.lastname }}</h3>
						</div>
						<!-- ./ User Info -->
						<!-- User Info -->
						<div class="user-bottom-info">
							<div class="row">
								<div class="col-md-12">
									<span>Email</span>
									<p>{{ student.email }}</p>
								</div>
								<div class="col-md-12">
									<span>Mobile No.</span>
									<p>{{ student.phone }}</p>
								</div>
								<div class="col-md-12">
									<p class="address">
									{{ student.address }}<br>
									{{ student.address_2 }}<br>
									{{ student.zipcode }}<br>
									{{ student.municipality }}
								  </p>
								</div>
							</div>
						</div>
						<!-- ./ User Info -->
					</div>
					<div class="sidebar-links">
						<ul class="list-unstyled">
							<li><router-link to="/privacy-policy">Privacy Policy</router-link></li>
							<li><router-link to="/terms-conditions">Terms and Conditions</router-link></li>
						</ul>
						<span>© 2019 Spiike</span>
					</div>
				</div>

			</div>
			<div class="col-lg-9 col-md-8">

				<div class="profile-content__links">
					<div class="row">
						<div class="col-sm-12">
							<ul class="list-unstyled ">
								<li><router-link to="/mentor" class="btn btn-sm btn-custom btn-primary">Dashboard</router-link></li>
								<li><router-link to="/mentor/students" class="btn btn-sm btn-custom btn-secondary">My Students</router-link></li>
								<li><router-link to="/my-profile/edit" class="btn btn-sm btn-custom btn-primary">Edit Personal Info</router-link></li>
								<li><router-link to="/my-profile/change-password"  class="btn btn-sm btn-custom btn-tertiary">Change Password</router-link></li>
							</ul>
						</div>
					</div>
					<hr>
				</div>
				<div class="mb-2">
					 <div class="main-profile">

					 	<div class="student-list">

							    <table class="table table-striped" v-if="students">

							    	<thead>

							    	  <tr>

							    		<th>ID</th>

							    		<th>Full Name</th>

							    		<th>Email</th>

							    		<th>Phone</th>

							    		<th>Status</th>

							    		<th>Fee</th>

							    	  </tr>

							        </thead>

							        <tbody>

								    	<tr v-for="student in students.data" :key="student.id">

								    		<td>

								    			<template v-if="student.image != null">

						                          <img :src="`/users/${student.image}`" width="50" height="auto" /> <span class="caret"></span>

						                        </template>
						                        <template v-else>

						                          <img :src="'/images/user_image.png'" width="50" height="auto" /> <span class="caret"></span>

						                        </template>
						                        
								    		</td>
								    		<td>{{ student.firstname }} {{ student.lastname }}</td>
								    		<td>{{ student.email }}</td>
								    		<td>{{ student.phone }}</td>
								    		<td>
								    			 active
								    		</td>
								    		<td>
								    			 Php 300
								    		</td>
								    	</tr>
							        </tbody>
							    </table>
							    <pagination :data="students" :limit="5" @pagination-change-page="getResults"></pagination>
							</div><!-- Student List -->
					 	
					 </div>
				</div>

			</div>

		</div>
	</div>
</template>
<script>
	import Preloader from '../loader/Preloader.vue';

	export default {
		name: 'profile',
		components: { Preloader },
		created() {
			this.getStudent();
			this.getPosts();
			this.$store.dispatch('getRoles');
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
					about: null,
					role: '',
					image: 'user_image.png',
					show_profile: '',
				},
				postData: {}, 
				posts: [],
				show_profile: '',
				privacy: '',
				loading: true,
				students: {}

			}
		},
		created() {
			this.privacy = this.currentUserPrivacy;
			this.getStudent();
		},
		mounted() {
			if(this.postData.length) {
				return;
			}
			this.getResults();

			if(this.students.length) {
				return;
			}
			this.$store.dispatch('getStudents');
			this.getStudents();

			if(!this.isMentor) {
				this.$router.push('/');
			}
		},
		methods: {
			getStudent() {

				axios.get(`/api/students/${this.currentUserID}`, {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
					.then((response) => {
			
						this.student = response.data.student;
						this.loading = false;
					})
					.catch((error) => {
						console.log(error);
					})

			},
			getStudents(page = 1) {
				axios.get(`/api/mentorships/${this.currentUserID}?page=` + page, {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
					.then(response => {
						this.students = response.data.students;
					});
			},
			getResults(page = 1) {
				axios.get(`/api/mentorships/${this.currentUserID}?page=` + page, {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
					.then(response => {
						this.postData = response.data.students;
					});
			},
			updatePrivacy() {

				axios.post(`/api/students/update-privacy/${this.currentUserID}`, { 'privacy' : this.$data.privacy }
					, {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
					.then((response) => {

						this.privacy = response.data.privacy;
					})
					.catch((error) => {
						console.log(error);
					})
			}
		},
		computed: {
			currentUserID() {
				return this.$store.getters.currentUser.id;
			},
			currentUserPrivacy() {
				return this.$store.getters.currentUser.show_profile;
			},
			roles() {
				return this.$store.getters.roles;
			},
			currentUserToken() {
				return this.$store.getters.currentUser.token;
			},
			isMentor() {
                return this.$store.getters.currentUser.role == 8 ? true: false;
            }

		}
	}
</script>
