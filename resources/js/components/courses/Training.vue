<template>
   <div class="page-wrapper course-page">
		<!-- Start of Course-->
		<section id="courses-page" class="d-padding courses-page-content">
			<div class="container">
				
				<section class="training-section">

					<div class="sidebar">
						<aside class="widget-courses-category">
				 	 	 	<div class="mb-4"><h2>Trainings</h2></div>
				 	 	 	<ul class="list-unstyled" v-if="bundleCourses">
				 	 	 		<li 
				 	 	 			v-for="(bundle, index) in bundleCourses" 
				 	 	 			:key="bundle.id" 
				 	 	 			v-bind:class="{ active: index === activeIndex}">
				 	 	 			<span v-on:click="getBundleCourse(bundle.id, index)">{{ bundle.display_name }}</span>
				 	 	 		</li>
				 	 	 	</ul>
				 	 	 </aside>
			 	 	 </div>
			 	 	 <div class="main-view">
			 	 	 	
	    		 	 	<div class="bundle-courses">
	    		 	 		<div id="loader-front" v-if="loading">
	    		 	 			<div class="loading">
								    <Preloader />
								</div>
	    		 	 		</div>
							<template v-if="singleBundle">
								 <template v-if="isActiveBundle">

				                     <div class="single-training">
										<div class="row">
											<!-- <div class="col-lg-6">
												<div class="image" v-if="singleTraining.image">
													<img class="img-fluid" :src="`/images/${singleTraining.image}`" />
												</div>
												<div class="image" v-else>
													<img class="img-fluid" :src="`/images/abstract-bg.png`" />
												</div>
											</div> -->
											<div class="col-lg-12">
												<div class="training-content">
													<h2 class="font-weight-bold">{{ singleTraining.display_name }}</h2>
													<p>{{ singleTraining.description }}</p>

													<div class="price" v-if="singleTraining.id != 7">
														<span>From {{ singleTraining.reg_price | currency }}</span>
									    				<strong>{{ singleTraining.discount_price | currency }}</strong>
									    			</div> 

									    			<div class="action-button">
						    		 	 					<button v-if="singleTraining.id != 7" class="btn btn-primary btn-wide font-weight-bold" @click="addCart(singleTraining)"> 
																	<span>Add to cart</span>
															</button>
															<template  v-if="singleTraining.id == 7">
																<p>Register a free account to view free video courses</p>
															</template>
					    							</div>
				    							</div>

											</div>
										</div>
									</div>

							    </template>
							</template>
							<div class="training-content">

		    		 	 		<div class="row">	
		    		 	 			 <div class="col-md-12" v-if="isActiveBundle">
		    		 	 			 	 <h4 class="font-weight-bold">Courses Included:</h4>
		    		 	 			 </div>		
		    		 	 			<template v-if="singleBundle">
			    						<div class="col-lg-4 col-md-4 col-sm-6" v-for="course in singleBundle" v-bind:key="course.id">
			    		 	 				 <!-- Single Course Item Start -->
			    		 	 				 <router-link :to="`/courses/${course.id}`" class="single-course-item">	
												 <div>
												 	<div class="course-thumb-area">
												 		<img class="img-fluid" :src="`/images/${course.image}`" />
												 	</div>
												 	<!-- /.single-thumb-area -->
												 	<div class="course-content">
												 		<h3>{{ course.title }}</h3>
						
												 		<div class="course-meta">
													 		<template v-if="course.rating">
												 				<div class="rating"><star-rating :inline="true" :star-size="20" :read-only="true"  :increment="0.01" :show-rating="false" :rating="course.rating"></star-rating> <span class="info"><strong>{{ course.rating }}</strong> ({{ course.total_students }})</span></div>
												 			</template>
													 	</div>
												 	</div>
												 </div>
											 </router-link>
			    		 	 				 <!-- /.single-course-item -->
			    		 	 			</div>
		    						</template>
		    						<template v-if="!isActiveBundle">
		    							<div class="col-lg-12">
		    								<h4>Coming Soon</h4>
		    							</div>	
		    						</template>
		    		 	 		</div>

		    		 	 	</div>
		    		 	 		
	    		 	 	</div>
				    		 	 
			 	 	 </div>

		 	 	</section>
		    	
		    </div>
		</section>
		<!-- End of Course -->

   
   </div>
</template>

<script>
	import carousel from 'vue-owl-carousel';
	import Preloader from '../loader/Preloader.vue';
	import { mapActions } from 'vuex';
	export default {
		name: 'courses',
		components: { carousel, Preloader },
		data() {
			return {
				loading: true,
				courses: [],
				error: null,
				testimonial_is_loading: false,
				bundleCourses: null,
				singleBundle: null,
				isActive: false,
				activeIndex: null,
				singleTraining: {},
				isActiveBundle: true,
				isActiveSingle: true,
				activeSingleIndex: null,
				isSingleAllActive: true,
				carts: [],
				cartadd: {
					id: '',
					name: '',
					price: '',
					amount: '',
					isBundle: true
				},
				total: '0',
				badge: '0', 
				quantity: '1',
				totalprice: '0',
				isPurchased: false,
				bundled_ready: false,
				single_ready: false,
			}
		},
		computed: {
			
			categories() {
				return this.$store.getters.categories;
			},
			currentUser() {
				return this.$store.getters.currentUser;
			},
			isLoggedIn() {
                return this.$store.getters.isLoggedIn;
            },
            inCart() {
                return this.$store.getters.inCart
            }

		},
		created() {

			if(this.categories.length) {
				return
			} else {
				this.$store.dispatch('getCategories')
			}
		},
		mounted() {
			this.getReviews();
			this.getAllBundleCourses();
			this.viewCart();
			//this.checkStudentAccess();
		},
		methods: {
			...mapActions(['addInCart']),
			viewCart(){
				this.carts = this.inCart; 
			},
			addCart(pro) {
				this.cartadd.id = pro.id;
				this.cartadd.name = pro.display_name;
				this.cartadd.price = pro.discount_price;
				this.cartadd.amount = 1;
				this.carts.push(this.cartadd);
				this.cartadd = {};
				this.storeCart();
				
				this.$store.dispatch('addInCart', this.carts);
			},
			removeCart(pro) {
				this.carts.splice(pro, 1);
				this.storeCart();
			},
			storeCart() {
				let parsed = JSON.stringify(this.carts);
				this.viewCart();
			},
			getAllBundleCourses() {
					axios.get(`/api/bundle-courses-list`)
						.then((response) => {
							
							this.activeIndex = 0;
							this.bundleCourses = response.data.access_levels;

							if(this.bundleCourses) {
								this.singleBundle = true;
								this.getBundleCourse(this.bundleCourses[0]['id']);
							}

						})
						.catch((error) => {
							console.log(error);
							this.error = error.message;
					})
			},
			showCourse(id, index = 0) {
				this.activeSingleIndex = index;
				this.isSingleAllActive = false;
				this.getAllCourses = '';
				axios.get(`/api/courses-by-category/${id}`)
						.then((response) => {
							console.log(response.data);
							this.courses = response.data.courses;
						})
						.catch((error) => {
							console.log(error);
							this.error = error.message;
						})
			},
			getBundleCourse(id, index = 0) {
				this.activeIndex = index;
				this.isActive = !this.isActive;
				this.getAllCourses = '';
		
				axios.get(`/api/single-bundle/${id}`)
						.then((response) => {

							this.singleBundle = [];
							this.singleBundle = response.data.courses;
							this.singleTraining = response.data.training;
							this.isActiveBundle = response.data.hasCourses;

							let currentCarts = JSON.parse(localStorage.getItem('carts'));
	
								if(currentCarts) {

									let is_added_to_cart = currentCarts.find( item => parseInt(item.id) == this.$data.singleTraining.id );

									//If cart is on the add to cart list
									//this.inCart = ( is_added_to_cart != undefined) ? true: false;
								}
							this.bundled_ready = true;
						})
						.catch((error) => {
							console.log(error);
							this.error = error.message;
						})
			},
			showAllCourse() {
				this.error = this.post = null
     			this.isSingleAllActive = true;
     			this.activeSingleIndex = null;
				axios.get('/api/courses-public')
				  .then((response) => {

					this.courses = response.data.courses;

					this.single_ready = true;
				  })	
				  .catch((error) => {
				  		console.log(error);
				  });
			},
			getReviews() {
				axios.get('/api/approved-reviews')
				.then((response) => {
					this.testimonial_is_loading = true;
					this.reviews = response.data.reviews;
					this.loading = false;
				})
				.catch((error) => {
					console.log(error);
				})
			}

		},
	
	}

</script>
<style scoped>
    .training-content {
    	padding-left: 30px;
    }
	.bundle-courses .row {
	    justify-content: flex-start;
	}
	.courses-page-content {
	    background: #f5f5fa;
	}
	.single-training {
    	margin: 40px 0;
    	padding-bottom: 40px;
	}
    .price {
    	margin-bottom: 50px;
    }
    .price strong {
    	font-size: 40px;
    	display: block;
    }
    .price span {
	    display: inline-block;
	    text-decoration: line-through;
	    font-size: 21px;
	    color: #716f6f;
    }
    section.training-section {
	    display: flex;
	}
	.action-button .btn {
		background: #4CAF50;
    	border: 1px solid #4caf50;
	}
    @media screen and ( max-width: 767px) {
    	.single-training .image {
    		padding: 0;
    		margin-bottom: 20px;
    	}
    	.training-content {
	    	padding-left: 0;
	    }
    }
</style>