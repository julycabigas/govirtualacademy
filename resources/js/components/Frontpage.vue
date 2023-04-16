<template>

   <div class="page-wrapper homepage">

   		<div id="loader-front" v-if="loading">

 			<div class="loading">

			    <Preloader />

			</div>

 		</div>
 		<section class="slider-banner-section">
 			<div class="container">
 				<div class="row">
 					<div class="col-md-12 text-center">
 						<div class="text-block">
							<h1>Welcome to Virtual Academy PH</h1>
							<p>Learn different aspects of digital marketing</p>
						</div>
 					</div>
 				</div>
 			</div>
 		</section>
		<!-- Start of Leads -->
		<section class="leads d-padding">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="single-lead">
							<div class="single-lead__image">
								<img :src="'/leads/ebook.svg'" alt="online courses" width="100%">	
							</div>
							<p><strong>Modern approach</strong>
							<span>Explore a variety of fresh topics</span></p>
						</div>
					</div>
					<div class="col">
						<div class="single-lead">
							<div class="single-lead__image">
								<img :src="'/leads/unlock.svg'" alt="Lifetime Accesss" width="100%">	
							</div>
							<p><strong>Quality video tutorials</strong>
							<span>Learn and improve yourself at your own pace </span></p>
						</div>
					</div>
					<div class="col">
						<div class="single-lead">
							<div class="single-lead__image">
								<img :src="'/leads/medal.svg'" alt="Instruction" width="100%">	
							</div>
							<p><strong>Become digitally certified</strong>
							<span>Learn from the digital experts and mentors</span></p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End of Leads -->

		<!-- Strat of Featured Courses-->
<!--    	    <section id="courses-page" class="d-padding courses-page-content gray-bg" v-if="course_is_loading">
			<div class="container">
				<div class="sec-title text-center pb-3">
					<h2>Featured Courses</h2>
				</div>
		    	<div class="row">
		    		 <div class="col-lg-12 col-md-12">

		    		 	 <div class="courses-page-content">
		    		 	 	<div class="courses-content">
		    		 	
		    		 	 			<carousel :items="4" :nav="false" :responsive="{0:{items:1,autoHeight:true,nav:false},450:{items:2,nav:false},600:{items:3,nav:false},992:{items:4,nav:false}}"
		    		 	 				class="carousel">
		    		 	 				<template slot="prev"><span class="arrow prev"><font-awesome-icon icon="chevron-left" /></span></span></template>
			    		 	 			<div class="wrap-course pl-2 pr-2"  v-for="course in featured_course" :key="course.id">
			    		 	 
											 <div class="single-course-item">
											 	<div class="course-thumb-area">
											 		<img class="img-fluid" :src="`/images/${course.image}`" />
											 	</div>
										
											 	<div class="course-content">
											 		<h3><router-link :to="`/courses/${course.id}`">{{ course.title }}</router-link></h3>
											 		<div class="course-meta">
											 			<div>
												 			<template v-if="course.rating">
												 				<div class="rating"><star-rating :inline="true" :star-size="20"  :increment="0.01" :read-only="true" :show-rating="false" :rating="course.rating"></star-rating> <span class="info"><strong>{{ course.rating }}</strong> ({{ course.total_students }})</span></div>
												 			</template>
											 			</div>
												 		<div class="course-price text-capitalize text-right">
												 			{{ course.discount_price | currency }}
												 		</div>
												 	</div>
											 	</div>
											 </div>
			    		 	 			
			    		 	 			</div>
			    		 	 			<template slot="next"><span class="arrow next"><font-awesome-icon icon="chevron-right" /></span></span></template>
		    		 	 			</carousel>
		    		 	 		
		    		 	 	</div>
		    		 	 </div>
		    	
		    		 </div>
		    	</div>
		    </div>
		</section> -->
		<!-- End of Courses -->




   		<!-- Start of Course Outline -->
        <section class="d-padding course-outline-area"  v-if="va_is_loading">
        	<div class="container">
        		 <div class="sec-title text-center">
        		 	<h2>Featured Training</h2>
        		 </div>

				 <!-- Start of Course Content -->
    		 	 <div class="courses-page-content">
    		 	 	<div class="courses-content">
						<h2 class="training-title text-center">{{ training.display_name }}</h2>
    		 	 		<div class="training-info text-center">
		        		 	<h3 class="font-weight-bold">{{ training.discount_price | currency }}</h3>
		        		</div>
    		 	 		<div v-if="va_course">
							<!-- <carousel :items="4" :nav="false" :autoHeight="true" :responsive="{0:{items:1,autoHeight:true,nav:false},450:{items:2,nav:false},600:{items:3},992:{items:4}}"
								class="carousel"
								> -->
								<!-- <template slot="prev"><span class="arrow prev"><font-awesome-icon icon="chevron-left" /></span></span></template> -->
								<div class="row">

		    		 	 			<div class="col-md-3 wrap-course pl-2 pr-2" v-for="course in va_course" :key="course.course.id">
		    		 	 				 <!-- Single Course Item Start -->
										 <div class="single-course-item">
										 	<div class="course-thumb-area">
										 		<img class="img-fluid" :src="`/images/${course.course.image}`" />
										 	</div>
										 	<!-- /.single-thumb-area -->
										 	<div class="course-content">
										 		<h3><router-link :to="`/courses/${course.course.id}`">{{ course.course.title }}</router-link></h3>
										 		<!-- <p>{{ course.course.short_description }}</p> -->
										 		<div class="course-meta">
										 			<div>
												 		<template v-if="course.course.rating">
											 				<div class="rating"><star-rating :inline="true" :star-size="20" :read-only="true" :increment="0.01" :show-rating="false" :rating="course.course.rating"></star-rating> <span class="info"><strong>{{ course.course.rating }}</strong> ({{ course.course.total_students }})</span></div>
											 			</template>
										 			</div>
											 	</div>
										 	</div>
										 </div>
		    		 	 				 <!-- /.single-course-item -->
		    		 	 			</div>

	    		 	 			<!-- <template slot="next"><span class="arrow next"><font-awesome-icon icon="chevron-right" /></span></span></template> -->
		        		 <!-- 	 </carousel> -->
							</div>

							<div class="link-to-training text-align-center">
								<router-link class="btn btn-primary" :to="`trainings/${training.id}`">CLICK HERE TO PURCHASE</router-link>
							</div>
    		 	 		</div>
    		 	 	</div>
    		 	 </div>
    		 	 <!-- End of Course Content -->
        	</div>
        </section>  
		<!-- End of Course Outline -->

		<!-- <section id="pricing" class="d-padding pricing-area">
			 <div class="container">
			 	<div class="sec-title text-center">
					<h2>How to Register and Purchase? Watch the video below</h2>
				</div>
				<div class="courses-pricing pb-3 text-center">
					<div class="videoWrapper">
						<iframe src="https://player.vimeo.com/video/411767642" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
					</div>
				</div>
			 </div>
		</section> -->
		<!-- End of Short Info -->


        <!-- Start of Testimonials -->
        <section class="testimonial-area d-padding"  v-if="testimonial_is_loading">
        	<div class="container">
        		 <div class="sec-title pb-3 text-center">
        		 	 <h2>What our students have to say</h2>
        		 </div>
        		 <div class="testimonial-carousel">
        		 	<div  v-if="reviews.length > 0">	
	        		 	<carousel :items="1" :nav="false">
		        		 	 <div class="single-testimony" v-for="review in reviews" :key="review.id">
		        		 	 	<div class="testimony-img" v-if="!review['image']">
						 	  		<img :src="`/users/${review.user.image}`" width="64" alt="User Image">
						 	  	</div>
						 	  	<div class="testimony-img" v-else>

						 	  		<img :src="`/images/${review['image']}`" width="64" alt="Review Thumbnail">
						 	  	</div>
		        		 	 	<strong v-if="review['image']">{{ review.name}}</strong>
		        		 	 	<strong v-else>{{ review.user.firstname }}</strong>
		        		 	 	<div class="testimony-detail" v-html="review.content"></div>
		        		 	 </div>
	        		 	 </carousel>
        		 	 </div>
        		 </div>
        	</div>
        </section>
		<!-- End of Testminoials -->

   </div>

</template>

<script>
	import carousel from 'vue-owl-carousel';
	import StarRating from 'vue-star-rating';
	import Preloader from './loader/Preloader.vue';

	export default {
		name: 'frontpage',
		components: { carousel, StarRating, Preloader },
		data() {
			return {
				featured_course: [],
				va_course: {},
				reviews: [],
				course_is_loading: false,
				va_is_loading: false,
				testimonial_is_loading: false,
				loading: true,
				training: {}
			}
		},
		beforeMount() {
			
			this.getReviews();
		},
		mounted() {
			// Get Featured Course
			axios.get('/api/featured-course')
				.then((response) => {
					this.course_is_loading = true;
					this.featured_course = response.data.courses;

				})
				.catch((error) => {
					console.log(error);
				});

			// Get Virtual Assistant Course	
			axios.get('/api/virtual-assistant-course')
				.then((response) => {
					this.va_is_loading = true;
					this.va_course = response.data.courses;
					this.loading = false;
					this.training = response.data.training;
				})
				.catch((error) => {
					console.log(error);
				})	

		},
		methods: {
			getReviews() {
				axios.get('/api/approved-reviews')
				.then((response) => {
	
					this.testimonial_is_loading = true;
					this.reviews = response.data.reviews;
				})
				.catch((error) => {
					console.log(error);
				})
			}
		}
	}

</script>
<style>
.link-to-training.text-align-center {
    text-align: center;
}
.videoWrapper {
  position: relative;
  padding-bottom: 56.25%; /* 16:9 */
  height: 0;
}
.videoWrapper iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
.testimonial-area .owl-carousel .owl-item img {
    border-radius: 50%;
    object-fit: cover;
    height: 100%;
    width: 100%;
}
.testimony-detail {
	max-width: 800px;
	margin: 0 auto;
}
button:hover,
button:focus {
	outline: none;
}
.courses-content {
    margin-left: -5px;
    margin-right: -5px;
}
.training-info h3 {
	display: inline-block;
    padding: 6px 25px;
    border-radius: 25px;
    color: #fa5656;
}
.single-testimony {
	width: 100%;
	text-align: center;
    padding: 30px;
    margin: 0 10px;
}
.owl-stage {
    display: flex;
    align-items: stretch;
}
.owl-stage .owl-item {
	display: flex;
}
</style>