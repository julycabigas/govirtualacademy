<template>
	<section class="page-content  d-padding webinar-area">
		<div id="loader-front" v-if="loading">
 			<div class="loading">
			    <Preloader />
			</div>
 		</div>
		 <div class="container">

		 	 <div class="webinar-list">

			 	 	<div class="row">
			 	 			
							<div class="col-sm-12 col-md-12 col-lg-12" v-for="webinar in webinars" :key="webinar.id">
								
								<div class="single-webinar">
									<!-- .single-thumb-area -->
									<div class="img-wrap">
										<img class="img-fluid" :src="`/images/${webinar.image_url}`" />
									</div>
									<!-- /.single-thumb-area -->
							
									<div class="inner-box">
											<h3>{{ webinar.name }} </h3> 
											<strong class="host">Host: {{ webinar.host }}</strong>
											<div class="text" v-html="webinar.description"></div>

											<div class="date">Date: <strong>{{ webinar.date }}</strong> </div>
											<div class="date time">Time: <strong>{{ webinar.time }}</strong> </div>
									</div>
						 	 	
						 		</div>

							</div>

					</div>


		 	 	</div>
		 	 
		 	 </div>

	</section>

</template>

<script>
    import Preloader from '../loader/Preloader.vue';
	export default {
		name: 'webinars',
		components: { Preloader },
		data() {

			return {
				loading: true,
				webinars: {}
			}
			
		},
		mounted() {
			this.getResults();
		},
		methods: {
			getResults(page = 1) {
				axios.get('/api/webinars-list?page=' + page, {
					headers: {
						"Authorization": `Bearer ${this.currentUserToken}`
					}
				}) 
				.then(response => {
						console.log(response.data);
						this.webinars = response.data.webinars;
						this.loading = false;
					});
			},
		},
		computed: {
			currentUserToken() {
				return this.$store.getters.currentUser.token;
			}
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