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
	
				<div class="main-home">

					<div class="row">
						
						<div class="col-md-4">
							
							<div class="col-block">
								
								<h5>Total Earnings</h5>	
								<h2></h2>

							</div>

						</div>
						<div class="col-md-4">
							
							<div class="col-block">
								
								<h5>Your Balance</h5>	
								<h2></h2>

							</div>

						</div>

						<div class="col-md-4">
							
							<div class="col-block">
								
								<h5>Total Students</h5>	
								<h2></h2>

							</div>

						</div>
						<div class="col-md-4">
							
							<div class="col-block">
								
								<h5>New Enrollee</h5>	
								<h2></h2>

							</div>

						</div>

					</div>

				</div>
			
				<div class="mt-2" v-if="!isEmployer && !isMentor">
					<h4 class="mt-4 mb-3 font-weight-bold news-heading"><i><font-awesome-icon icon="star" /></i> Latest News</h4>
				
					<article class="single-post card card-body mt-2 mb-2" v-for="post in postData.data" :key="post.id">
						<h2>{{ post.title }}</h2>
						<div v-html="post.content"></div>
					</article>
					
					<pagination :data="postData" @pagination-change-page="getResults"></pagination>
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
				options: [
					{
						title: 'My Courses',
						subtitle: null,
						path: '/my-courses',
						external_path: false
					},
					{
						title: 'Your Info',
						subtitle: null,
						path: '/my-profile',
						external_path: false
					},
					{
						title: 'Examination',
						subtitle: null,
						path: '/my-profile/examination',
						external_path: false
					},
					{
						title: 'Certification',
						subtitle: null,
						path: '/my-profile/certification',
						external_path: false
					},					
					{
						title: 'Facebook Page',
						subtitle: null,
						path: 'https://www.facebook.com/',
						external_path: true
					},
					{
						title: 'Referral',
						subtitle: 'Coming Soon',
						path: '/',
						external_path: false
					},
					{
						title: 'Mobile App',
						subtitle: 'Coming Soon',
						path: '/',
						external_path: false
					},
					{
						title: 'Job Hiring',
						subtitle: 'Coming Soon',
						path: '/',
						external_path: false
					},
				],
				Mentoroptions: [
					{
						title: 'My Students',
						subtitle: null,
						path: '/mentor/students',
						external_path: false
					},
					{
						title: 'My Courses',
						subtitle: null,
						path: '/mentor/courses',
						external_path: false
					},	
					{
						title: 'Your Info',
						subtitle: null,
						path: '/my-profile',
						external_path: false
					}			

				],

			}
		},
		created() {
			this.privacy = this.currentUserPrivacy;
			this.getStudent();
			this.getPosts();
		},
		mounted() {
			if(this.postData.length) {
				return;
			}
			this.$store.dispatch('getPosts');
			this.getResults();

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
			getPosts() {
				axios.get(`/api/posts/`)
					.then((response) => {
			
						this.posts = response.data.posts;
					})
					.catch((error) => {
						console.log(error);
					})
			},
			getResults(page = 1) {
				axios.get('/api/posts?page=' + page)
					.then(response => {
						this.postData = response.data.posts;
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
            },
            isEmployer() {
                return this.$store.getters.currentUser.role == 9 ? true: false;
            }
		}
	}
</script>
<style scoped>
	.col-block {
	    background: #fff;
	    padding: 50px 20px;
	    text-align: center;
	    margin-bottom: 30px;
	}
	.col-block h2 {
		font-weight: 700;
	}
</style>