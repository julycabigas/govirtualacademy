<template>
	<section class="page-content  d-padding mentor-area">
		<div id="loader-front" v-if="loading">
 			<div class="loading">
			    <Preloader />
			</div>
 		</div>
		 <div class="container">
		 	<h1>Our Mentors</h1>

		 	 <div class="mentors-list">

			 	 	<div class="row">
			 	 			

							<div class="col-sm-6 col-md-6 col-lg-3" v-for="mentor in mentorsData.data" :key="mentor.id">
								
								<div class="single-mentor">
						 	 		<div>
							 	 		<div class="course-thumb-area">
							 	 		</div> 
							 	 		<div class="course-content">
							 	 			<div class="image">
							 	 				<template v-if="mentor.image != null">
                                                  <img class="img-fluid"  :src="`/users/${mentor.image}`" alt=""/> 
                                                </template>
                                                <template v-else>
                                                  <img class="img-fluid" :src="'/images/user_image.png'" alt="" />
                                                </template>
						
							 	 			</div>
							 	 			<div class="info">
							 	 				<div class="info-block">
							 	 					<h5>{{ mentor.firstname }} {{ mentor.lastname }}</h5> 
								 	 				<span>{{ mentor.position }}</span>
							 	 				</div>
							 	 				<div class="about" v-html="mentor.about"></div>
								 	 			
							 	 			</div>
								 	 		
								 	 	</div>
						 	 		</div>
						 		</div>

							</div>

					</div>

					 <pagination :data="mentorsData" :limit="5" @pagination-change-page="getResults"></pagination>


		 	 	</div>
		 	 
		 	 </div>

		 </div>

	</section>

</template>

<script>
    import Preloader from '../loader/Preloader.vue';
	export default {
		name: 'support',
		components: { Preloader },
		data() {

			return {
				loading: true,
				mentorsData: {}

			}
			
		},
		mounted() {
			this.getResults();
		},
		methods: {
			getResults(page = 1) {
				axios.get('/api/mentors?page=' + page)
					.then(response => {
						this.mentorsData = response.data.mentors;
						this.loading = false;
					});
			},
		}
	}

</script>
<style scoped>
.action {
	margin-top: 20px;
	margin-bottom: 20px;
}
.info-block h5 {
	font-weight: 600;
	margin: 0;
}
.info-block span {
    color: #f6961e;
}
h1 {
    font-size: 2em;
}
</style>