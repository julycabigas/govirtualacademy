<template>
	<div class="inner-info profile-content">
		<div id="loader-front" v-if="loading">
 			<div class="loading">
			    <Preloader />
			</div>
 		</div>
		<!-- Start of Breadcrumb -->
		<div class="breadcrumb">
			
				<ul class="list-unstyled">
					<li><router-link to="/mentors">All Mentors</router-link></li>
					<li><span>{{ mentor.firstname }} {{ mentor.lastname }}</span></li>
				</ul>
			
		</div>
		<!-- End of Breadcrumb -->
		<div class="row pt-3">
			<div class="col-lg-3 col-md-4">

				<div class="sidebar">

					<div class="profile-main-info"> 
						<!-- Start of profile pic -->
						<div class="profile-pic">
							<template v-if="mentor.image != null">
							  <img :src="`/users/${mentor.image}`" width="120" height="auto" /> 
						    </template>
						    <template v-else>
							  <img :src="'/images/user_image.png'" width="120" height="auto" /> 
						    </template>
						</div>
						<!-- End of profile pic -->
						<!-- User Info -->
						<div class="user-top-info">
							<h5>{{ mentor.firstname }} {{ mentor.lastname }}</h5>
						</div>
						<!-- ./ User Info -->
						<!-- User Info -->
						<div class="user-bottom-info">
							<div class="row">
								<div class="col-md-12">
									<span>Email</span>
									<p>{{ mentor.email }}</p>
								</div>
								<div class="col-md-12">
									<span>Mobile No.</span>
									<p>{{ mentor.phone }}</p>
								</div>
								<div class="col-md-12">
									<p class="address">
									{{ mentor.address }}<br>
									{{ mentor.address_2 }}<br>
									{{ mentor.zipcode }}<br>
									{{ mentor.municipality }}
								  </p>
								</div>
							</div>
						</div>
						<!-- ./ User Info -->
					</div>
				</div>

			</div>
			<div class="col-lg-9 col-md-8">

	
				<div class="main-home">
					<h3>About Me</h3>
					<div v-html="mentor.about "></div>

				</div>

				<div class="main-stats">
					
					<div class="mt-2 row">
						<div class="col-md-3">
						
							  <div class="option-single"><h2>Total Students <span>{{ total_students }}</span></h2></div>
						
						</div>
						<div class="col-md-3">
						
							  <div class="option-single"><h2>Total Courses <span>N/A</span></h2></div>
						
						</div>
					</div>
				</div>
		

			</div>

		</div>
	</div>

</template>

<script>
	import Preloader from '../loader/Preloader.vue';

	export default {
		name: 'visible-profile',
		components: { Preloader },
		data() {
			return {
				mentor: {
					name: '',
					firstname: '',
					lastname: '',
					email: '',
					address: '',
					address_2: '',
					zipcode: '',
					municipality: '',
					about: '',
					role: '',
					image: 'user_image.png',
					show_profile: '',
				},
				show_profile: '',
				loading: true,
				total_students: ''

			}
		},
		computed: {

		},
		created() {
		},
		mounted() {
			this.getMentor();
			this.getallStudents();
		},
		methods: {
			getMentor() {

				axios.get(`/api/mentors/profile/${this.$route.params.id}`)
					.then(response => {
						this.mentor = response.data.mentor;
						this.loading = false;
				});

			},
			getallStudents() {

				axios.get(`/api/mentors/total_students/${this.$route.params.id}`)
					.then(response => {
						this.total_students = response.data.total_students;
				});

			},
		},
		
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
	.main-home {
	    margin-top: 60px;
	    padding: 20px;
	    background: #fff;
	    border-radius: 4px;
	    margin-bottom: 28px;
	    box-shadow: 0 10px 20px 0 rgba(221, 221, 221, 0.2);
	}
	.option-single h2 span {
	    display: block;
	    font-size: 29px;
	    font-weight: 500;
	    color: #f85b52;
	    margin-top: 20px;
	}
	.main-profile-area .user-top-info h3 {
	    padding: 0 10px;
	}
	@media ( max-width: 767px) {
		.main-home {
			margin-top: 30px;
		}
	}
</style>