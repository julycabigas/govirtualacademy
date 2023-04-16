<template>
	<div class="about-us-area">
		<div class="page-content">
				<!-- Start of intro -->
				<section class="intro-area">
					<div class="container">
						<div class="row">
							<div class="col-lg-12 col-md-12 text-center" >
									<h2 class="font-weight-bold">Our Vision</h2>
									<p>Virtual Academy PH team vision is to become the No.1 tutorial site in the global stage producing the best digital innovators all over the world majority of them Filipinos bridging the digital gap year after year. Delivering revolutionized tutorials to everyone who wants to learn and earn on all digital platforms daily. As technology evolves the whole team also evolves with it to ensure quality wise tutorials and increased profit on a regular basis. Spiike will make sure core values are exercised while the staff's career growth  and company growth will rise.</p>
							</div>
							<div class="col-lg-12 col-md-12">
								<div class="pl-4 pt-3 text text-center">
									<h2 class="font-weight-bold">Our Mission</h2>
									<p>Virtual Academy PH aims to establish a stable tutorial site producing high quality efficient tutorials that will help Filipinos achieve global competitiveness in technology innovation and evolution. The team will provide concise and efficient tutorial sessions that is backed up with examples and relevant references for faster student improvement. We will be more in depth in reaching our objectives while maintaining consistency and efficiency in helping our students achieve their goals in their chosen field as well as ensuring the welfare of our team.</p>
								</div>
							</div>
						</div>
					</div>
				</section>
				<!-- End of intro -->
								<!-- Start of Counter -->
				<section class="counter-area before-bg bg-image s-pd145" style="background-image: url(images/counter-bg.jpg);">
		            <div class="container">
		                <div class="row justify-content-md-center">
		                    <div class="col-lg-10">   
		                        <div class="row">
		                            <div class="col-lg-4 col-sm-4 col-6">
		                                <div class="single-counter">
		                                    <h2><span class="counter">4</span></h2>
		                                    <p>Training</p>
		                                </div><!--/.single-counter-->
		                            </div>
		                            <div class="col-lg-4 col-sm-4 col-6">
		                                <div class="single-counter">
		                                    <h2><span class="counter">21</span></h2>
		                                    <p>Courses</p>
		                                </div><!--/.single-counter-->
		                            </div>
		                            <div class="col-lg-4 col-sm-4 col-6">
		                                <div class="single-counter">
		                                    <h2><span class="counter">150</span></h2>
		                                    <p>Videos</p>
		                                </div><!--/.single-counter-->
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </section>
				<!-- End of Counter -->
				<!-- Start of intro -->
				<section class="team-area pt-5 pb-5" style="max-width: 550px;margin: 0 auto">
					<div class="sec-title text-center">
						<div class="container p-3">	
							<h2 class="font-weight-bold">Our Team</h2>
						</div>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-lg-6 col-md-12">
								<div class="single-team">
									 <div class="team-member-thumb">
									 	 <img :src="'images/july.jpg'" width="100%" />
									 </div>
									<h2>July Cabigas</h2>
									<span>Web Developer / Graphic Design</span>
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="single-team">
									 <div class="team-member-thumb">
									 	 <img :src="'images/jurie2.jpg'" width="100%" />
									 </div>
									<h2>Jurie Catalan</h2>
									<span>Digital Marketing, SEO and CRM Expert</span>
								</div>
							</div>
						</div>
					</div>
				</section>
				<!-- End of intro -->
				
		<!-- Strat of Short Info -->
		<section id="pricing" class="d-padding pricing-area">
			 <div class="container">
			 	<div class="sec-title text-center">
					<h2>How to Purchase</h2>
				</div>
				<div class="courses-pricing pb-3 text-center">
					<div class="grid">
						 <div class="single-item">
						 	<div><h3>Video Trainings</h3><p>These are bundled courses that you can purchase at a lower price.</p></div>
						 </div>
						 <div class="single-item">
						 	<div><h3>Sign Up for Free</h3><p>Sign up and learn from our free digital courses.</p></div>
						 </div>
					</div>
				</div>
			 </div>
		</section>
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
		        		 	 <div class="single-testimony" v-for="review in reviews">
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
		<!-- End of Page Content -->	
	</div>
	<!-- End of About Us Area-->
</template>

<script>
	import carousel from 'vue-owl-carousel';

	export default {
		name: 'about-us',
		components: { carousel },
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