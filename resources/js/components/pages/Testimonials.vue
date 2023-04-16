<template>
	<section class="d-padding about-us-area">
		 	<!-- Start of Testimonials -->
	        <section class="testimonial-area d-padding">
	        	<div class="container">
	        		 <div class="sec-title pb-3 text-center">
	        		 	 <h2>What our students have to say</h2>
	        		 </div>
	        		 <div class="testimonial-carousel">
	        		 	<carousel :items="1" :autoplay="true" :nav="false">
		        		 	 <div class="single-testimony">
		        		 	 	<div class="testimony-img">
		        		 	 		<img :src="'images/user_image.png'"  width="64" />
		        		 	 	</div>
		        		 	 	<strong>Zulaika</strong>
		        		 	 	<p>I work in project management and joined Udemy because I get great courses for less. The instructors are fantastic, interesting, and helpful. I plan to use Udemy for a long time!</p>
		        		 	 </div>
		        		 	 <div class="single-testimony">
		        		 	 	<div class="testimony-img">
		        		 	 		<img :src="'images/user_image.png'"  width="64" />
		        		 	 	</div>
		        		 	 	<strong>Marco</strong>
		        		 	 	<p>Thank you Udemy! You've renewed my passion for learning and my dream of becoming a web developer.</p>
		        		 	 </div>
		        		 	 <div class="single-testimony">
		        		 	 	<div class="testimony-img">
		        		 	 		<img :src="'images/user_image.png'"  width="64" />
		        		 	 	</div>
		        		 	 	<strong>Justin</strong>
		        		 	 	<p>The best part about Udemy is the selection. You can find a course for anything you want to learn!</p>
		        		 	 </div>
		        		 	 <div class="single-testimony">
		        		 	 	<div class="testimony-img">
		        		 	 		<img :src="'images/user_image.png'"  width="64" />
		        		 	 	</div>
		        		 	 	<strong>Borivoje</strong>
		        		 	 	<p>Udemy is a life saver. I don't have the time or money for a college education. My goal is to become a freelance web developer, and thanks to Udemy, I'm really close.</p>
		        		 	 </div>
	        		 	 </carousel>
	        		 </div>
	        	</div>
	        </section>
			<!-- End of Testminoials -->
	</section>
</template>

<script>
	import carousel from 'vue-owl-carousel';
	export default {
		name: 'testimonials',
		components: { carousel },
	}
</script>
<style scoped>
.testimonial-area {
	background: transparent;
}
</style>