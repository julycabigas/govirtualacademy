<template>
	<section class="page-content  d-padding mentor-area">
		<div id="loader-front" v-if="loading">
 			<div class="loading">
			    <Preloader />
			</div>
 		</div>
		 <div class="container">

		 	 <div class="mentors-list">

			 	 	<div class="row">
			 	 			
							<div class="col-sm-12 col-md-12 col-lg-12" v-for="category in resources" :key="category.id">
								
								<div class="single-resources">
						 	 		<div>
							 	 		<div class="resource-nfo">
											 <h3>{{ category.name }} </h3> 
							 	 		</div> 
							 	 		<div class="resource-list">
                                            <div class="row" v-if="category.resource">
                                                <div class="col-md-12" v-for="resource in category.resource" :key="resource.id">
													<div class="single-resource">
														<h4>{{ resource.name }} <button v-on:click="showingResource(category.id + '-'+ resource.id)" class="btn btn-drop">Click to show</button></h4>
														<div class="description" :id="category.id + '-'+ resource.id">
															<div v-html="resource.description"></div>	
														</div>
												    </div>
												</div> 
											</div>
								 	 		
								 	 	</div>
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
	import JQuery from 'jquery';
	export default {
		name: 'resources',
		components: { Preloader },
		data() {

			return {
				loading: true,
				mentorsData: {},
				resources: {},
				button: '+'
			}
			
		},
		mounted() {
			this.getResults();
		},
		methods: {
			showingResource(event) {
				let $ = JQuery;

				$('#' + event).toggleClass('show');
				//$(this).closest('.single-resource').find('.description').sligeToggle();
			
				

			},
			getResults(page = 1) {
				axios.get('/api/all-resources?page=' + page , {
					headers: {
						"Authorization": `Bearer ${this.currentUserToken}`
					}
					})
					.then(response => {
						console.log(response.data);
						this.resources= response.data.resources;
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
.description {
	display: none;
}
.description.show {
	display: block;
}
h1 {
    font-size: 2em;
}
</style>