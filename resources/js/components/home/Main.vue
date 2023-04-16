<template>
	
	 <div class="main-dashboard">
	 	<div id="loader-front" v-if="loading">
 			<div class="loading">
			    <Preloader />
			</div>
 		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-6 col-6 col-option">
						<div class="option-single">
							<div>
								<strong>{{ totaltraining }}</strong>
								<h2>Total Trainings</h2>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-6 col-option">
						<div class="option-single">
							<div>
								<strong>{{ totalcourses }}</strong>
								<h2>Total Courses</h2>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-6 col-option">
						<div class="option-single">
							<div>
								<strong>{{ totalvideos }}</strong>
								<h2>Total Videos</h2>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-6 col-option">
						<div class="option-single">
							<div>
								<strong>{{ totalstudents }}</strong>
								<h2>Total Students</h2>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 full-height">
				<div class="option-single">
					<div>
						<strong>{{ totalpurchases | currency }}</strong>
						<h2>Total Sales</h2>
						<hr>
						<strong>{{ pendingpurchases | currency }}</strong>
						<h2>Total Pending Sales</h2>
					</div>
				</div>
			</div>

		</div>
	</div>
		
</template>
<script>
    import Preloader from '../loader/Preloader.vue';
	export default {
		name: 'main-home',
		components: { Preloader },
		data() {
			return {
				options: [
					{
						title: 'Courses',
						subtitle: null,
						path: '/my-courses',
						external_path: false
					},
					{
						title: 'Latest News',
						subtitle: null,
						path: '/my-profile/news',
						external_path: false
					},
					{
						title: 'Membership Info',
						subtitle: null,
						path: '/my-profile',
						external_path: false
					},
					{
						title: 'Facebook Page',
						subtitle: null,
						path: 'https://www.facebook.com/',
						external_path: true
					},
					{
						title: 'Certification',
						subtitle: null,
						path: '/my-profile/certification',
						external_path: false
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
				loading: true,
				totaltraining: '',
				totalcourses: '',
				totalvideos: '',
				totalstudents: '',
				totalpurchases: '',
				pendingpurchases: ''
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		mounted() {
			this.allTraining();
			this.allCourses();
			this.allVideos();
			this.allStudents();
			this.allPurchased();
			this.allPending();
		},
		methods: {
			allTraining() {
					axios.get('/api/stats-training', {
 					 headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})		
					.then((response) => {
						this.totaltraining = response.data.total;
					})
					.catch((error) => {
						this.error = error.message;
					})
			},
			allCourses() {
					axios.get('/api/stats-courses', {
 					 headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})		
					.then((response) => {
						this.totalcourses = response.data.total;
					})
					.catch((error) => {
						this.error = error.message;
					})
			},
			allVideos() {
					axios.get('/api/stats-videos', {
 					 headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})		
					.then((response) => {
						this.totalvideos = response.data.total;
					})
					.catch((error) => {
						this.error = error.message;
					})
			},
			allStudents() {
					axios.get('/api/stats-students', {
 					 headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})		
					.then((response) => {
						this.totalstudents = response.data.total;
					})
					.catch((error) => {
						this.error = error.message;
					})
			},
			allPurchased() {
					axios.get('/api/stats-purchased', {
 					 headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})		
					.then((response) => {
						this.totalpurchases = response.data.total;
					})
					.catch((error) => {
						this.error = error.message;
					})
			},
			allPending() {
				
				axios.get('/api/stats-pending-purchased', {
					 headers: {
				  	 "Authorization" : `Bearer ${this.currentUser.token}`
				  }
				})		
				.then((response) => {
					this.pendingpurchases = response.data.total;
				})
				.catch((error) => {
					this.error = error.message;
				})

					this.loading = false;
			}
		}
		

	}
</script>
<style scoped>
.main-dashboard .full-height > div {
    height: calc(100% - 6px);
    background: #222f3f;
    color: #fff;
}
.main-dashboard .option-single h2 {
	color: #a2a2a9;
}
</style>