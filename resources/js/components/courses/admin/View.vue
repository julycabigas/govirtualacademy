<template>
	<div id="myproduct">
		<div class="course-view">
			<template>
					<div>
						<ul class="list-unstyled">
							<li><router-link to="/admin/courses">Back to all courses</router-link></li>
						</ul>
					</div>
					<!-- Start of Course Banner -->
					<section>
						<div class="container">
							  <h1>{{ course.title }}</h1>
							  <p>{{ course.short_description }}</p>
						</div>
					</section>
					<!-- End of Course Banner -->

				   <!-- Start of Course Info -->
					<section class="course-info">
						<div class="container">
							<div class="row">
									
								<div class="col-lg-8 col-md-6">
									
									<!-- Start of Course highlight -->
									<div class="course-highlight">
										<h2 class="course-title">What you'll learn</h2>
										<div v-html="course.learn"></div>
									</div>
									<!-- End of Course highlight -->
									<!-- Start of Course content -->
									<div class="course-content">
										
										<h2 class="course-title">Course Content</h2>
										<div class="lectures-container">

											<template v-if="lessons.length">
												<!-- Start of Lecture Item -->
												<div class="lecture-item" v-for="( lesson, index ) in lessons" :key="index">
													  <div class="lecture-title">
														  <div class="lecture-item__icon">
														  	  <span><font-awesome-icon icon="play" /></span>
														  </div>
													  	  <div class="lecture-item__info">
													  	  	 <div class="detail">
													  	  	 	<strong>Lesson {{index + 1}}</strong>
													  	     	<h4>{{ lesson.title }}</h4>
													  	  	 </div>
													  	     <div class="time">{{ lesson.time }}</div>
													  	  </div>
													  	  
													  </div>
												</div>
												<!-- End of Lecture Item -->
											</template>
											
										</div>	 
									
									</div>
									<!-- End of Course content -->	
									<!-- Start of Requirement -->
									<div class="course-requirement">
										<h2 class="course-title">Requirements</h2>
									   <div v-html="course.requirement"></div>
									</div>
									<!-- End of Requirement -->
									<!-- Start of Course Description -->
									<div class="course-description">
										<h2 class="course-title">Description</h2>
									   <div v-html="course.description"></div>
									</div>
									<!-- End of Course Description -->

								</div>
								<div class="col-lg-4 col-md-6">
									
				                   <!-- Start of Course Sidebar -->
									<div class="course-sidebar" id="course-sidebar">
										<div class="course-thumb">
											<img :src="`../../images/${course.image}`" width="100%" />
										</div>
										<div class="course-widget">
											<div class="course-price">
												<h2><span>{{ course.discount_price | currency }}</span>  <sup>{{ course.orig_price | currency  }}</sup></h2>
												<hr>
											</div>
											<div class="course-inclusion">
												<strong>Includes</strong>
												<div v-html="course.inclusions"></div>
											</div>
										</div>	
									</div>
									<!-- End of Course Cart -->	
				                 
								</div>	

							</div>
						</div>
					</section>
					<!-- End of Course info -->
				</template>	
		
		</div>
	</div>
</template>

<script>
	export default {
		name: 'view-course',
		data() {
			return {
				course: {},
				lessons: [],
				loading: false,
				carts: [],
				cartadd: {
					id: '',
					name: '',
					price: '',
					amount: ''
				},
				total: '0',
				badge: '0', 
				quantity: '1',
				totalprice: '0',
				inCart: false,
				access: [],
				userAccess: {},
				isPurchased: false
			}
		},
		created() {

		   this.getCourse();
		   this.getCourseVideo();	
		},
		mounted() {

		},
		methods: {
			getCourse() {
           		axios.get(`/api/courses/${this.$route.params.id}`, {})
           		     .then((response) => {
           		     		this.course = response.data.course
           		     })
           		     .catch((err) => {
           		     	console.log(err);
           		 })
			}, 
			getCourseVideo() {
	       		axios.get(`/api/video-by-course/${this.$route.params.id}`)
					 .then((response) => {
					 	this.lessons = response.data.videos;
					 })
					 .catch((error) => {
					 	console.log(error);
					 })

			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			isLoggedIn() {
                return this.$store.getters.isLoggedIn;
            }
		}
	
	}
</script>