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
					<li><router-link to="/profile">All VA</router-link></li>
					<li><span>{{ student.firstname }} {{ student.lastname }}</span></li>
				</ul>
			
		</div>
		<!-- End of Breadcrumb -->
		<div class="row pt-3">
			<div class="col-lg-3 col-md-4">

				<div class="sidebar">

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
				</div>

			</div>
			<div class="col-lg-9 col-md-8">

				<div class="box-section box-section-top">
					<h3>Badges & Certifications</h3>
					<div class="badges-list" v-for="badge in student.badges" :key="badge.id">
                          {{ badge.badges.name }} - Level {{ badge.total_star }}
					</div>
				</div>
				<div class="box-section">
					<h3>About Me</h3>
					<div v-html="student.about "></div>
				</div>
				<div class="box-section">
					<h3>Reviews</h3>
					<p>Coming soon!</p>
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
			this.getProfile();
			this.getallStudents();
		},
		methods: {
			getProfile() {

				axios.get(`/api/all-students/${this.$route.params.id}`)
					.then(response => {
						console.log(response.data.student);
						this.student = response.data.student;
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
	.box-section {
	    padding: 20px;
	    background: #fff;
	    border-radius: 4px;
	    margin-bottom: 15px;
		min-height: 150px;
	    box-shadow: 0 10px 20px 0 rgba(221, 221, 221, 0.2);
	}
	.box-section h3 {
		font-size: 1.3em;
    	font-weight: 600;
    	color: #062b48;
	}
	.box-section-top {
		margin-top: 60px;
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
		.box-section-top {
			margin-top: 30px;
		}
	}
</style>