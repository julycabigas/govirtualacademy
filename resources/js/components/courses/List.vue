<template>
   <div class="page-wrapper course-page">
        <div id="loader-front" v-if="loading">
 			<div class="loading">
			    <Preloader />
			</div>
 		</div>
		<!-- Start of Course -->
		<section class="d-padding courses-page-content">
			<div class="container">
				<div class="mb-4"><h2>Single Courses</h2></div>
				<section class="training-section">

					<div class="sidebar">
							
						<aside class="widget-courses-category">

				 	 	 	<ul class="list-unstyled" v-if="categories">
				 	 	 		<li 
				 	 	 			v-on:click="showAllCourse" 
				 	 	 			v-bind:class="{ active: isSingleAllActive }"
				 	 	 		    >
				 	 	 			<span>All </span>
				 	 	 		</li>
				 	 	 		<li 
				 	 	 			v-for="(category, index) in categories" 
				 	 	 			:key="category.id"
				 	 	 			v-bind:class="{ active: index === activeSingleIndex}">
				 	 	 			<span v-on:click="showCourse(category.id, index)">{{ category.name }}</span>
				 	 	 		</li>
				 	 	 	</ul>
				 	 	 </aside>
					 	
					</div>
					<div class="main-view">
		
		    		 	 	<div>
		    		 	 		<div class="row">			
		    		 	 			<template v-if="courses">
			    						<div class="col-lg-4 col-md-4 col-sm-6" v-for="course in courses" v-bind:key="course.id">
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
												 			<div>
												 				<template v-if="course.rating">
												 					<div class="rating"><star-rating :inline="true" :star-size="20"  :increment="0.01" :read-only="true" :show-rating="false" :rating="course.rating"></star-rating> <span class="info"><strong>{{ course.rating }}</strong> ({{ course.total_students }})</span></div>
												 				</template>
												 			</div>
													 		<div class="course-price text-capitalize text-right">
													 			<span>{{ course.discount_price | currency }}</span>
													 		</div>
													 	</div>
												 	</div>
												 </div>
											 </router-link>
			    		 	 				 <!-- /.single-course-item -->
			    		 	 			</div>
		    						</template>
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
	export default {
		name: 'courses',
		components: { carousel, Preloader },
		data() {
			return {
				categories: {
					name: '',
					description: ''
				},
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
				inCart: false,
				isPurchased: false,
				bundled_ready: false,
				single_ready: false,
			}
		},
		created() {
			this.showAllCourse()
		},
		mounted() {
			this.getReviews();
			//this.getAllBundleCourses();
			this.viewCart();
			this.getCategories();
			//this.checkStudentAccess();
		},
		methods: {
			getCategories() {
				axios.get(`/api/categories`)
					 .then((response) => {
					 	console.log(response.data.categories);
					 	this.categories = response.data.categories;
					 })
			},
			checkStudentAccess() {
				//get access id
				//check if user has access
				//disable adding if alredy exist
				//Add my course
				if(this.isLoggedIn) {

					axios.post(`/api/student-bundle-purchased/update/${this.currentUser.id}`, {
							'course_id' : this.$data.singleTraining.id
						}, {
								headers: { "Authorization" : `Bearer ${this.currentUser.token}`}
						})
						.then((response) => {
							this.isPurchased = response.data.hasPurchased;
						})
						.catch((error) => {
							console.log(error);
							this.error = error.message;
						})
				} else {

				}	
				
			},
			viewCart(){
				if(localStorage.getItem('carts')) {
					this.carts = JSON.parse(localStorage.getItem('carts'));
					this.badge = this.carts.length;
					this.totalprice = this.carts.reduce((total, item) => {
						return total + this.quantity  * item.price;
					}, 0) 

				}
			},
			addCart(pro) {
				this.cartadd.id = pro.id;
				this.cartadd.name = pro.display_name;
				this.cartadd.price = pro.discount_price;
				this.cartadd.amount = 1;
				this.carts.push(this.cartadd);
				this.cartadd = {};
				this.storeCart();
				this.inCart = true;
			},
			removeCart(pro) {
				this.carts.splice(pro, 1);
				this.storeCart();
				this.inCart = false;
			},
			storeCart() {
				let parsed = JSON.stringify(this.carts);
				localStorage.setItem('carts', parsed);
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
									this.inCart = ( is_added_to_cart != undefined) ? true: false;
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
<style scoped>
	.bundle-courses .row {
	    justify-content: center;
	}
	.courses-page-content {
	    background: #f5f5fa;
	}
	.course-meta {
	    display: flex;
	    justify-content: space-between;
	    align-items: center;
	}
	.single-course-item .course-content .course-price {
    	margin-top: 0;
	}
</style>