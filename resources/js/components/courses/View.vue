<template>
	<div id="myproduct">
		<div id="loader-front" v-if="loading">
 			<div class="loading">
			    <Preloader />
			</div>
 		</div>
		<!-- <div class="cart-button">
			<button class="btn btn-primary" data-toggle="modal" data-target="#cart">
				<i><font-awesome-icon icon="shopping-cart" /></i>   <span class="badge badge-light">{{badge}}</span>
			</button>
			<div class="modal fade" id="cart">
				 <div class="modal-dialog modal-dialog-centered modal-lg">
				 	<div class="modal-content">
				 		<div class="modal-header">
				 			<h5 class="modal-title">Your Cart</h5>
				 			<button class="close" data-dismiss="modal">&times;</button>
				 		</div>
				 		<div class="modal-body">
				 			<table class="table table-striped text-left">
				 				<tbody>
				 					<tr>
				 						<th>Name</th>
				 						<th>Price</th>
				 						<th>Amount</th>
				 						<th>Action</th>
				 					</tr>
				 					<tr v-for="(cart, n) in carts" v-bind:key="cart.id">
				 						<td>{{ cart.name}}</td>
				 						<td>Php {{ cart.price}}</td>
				 						<td width="100"><input type="text" readonly class="form-control" v-model="quantity"/></td>
				 						<td width="60">
				 							<button @click="removeCart()" class="btn btn-danger btn-sm">close</button>
				 						</td>
				 					</tr>
				 				</tbody>
				 			</table>
				 		</div>
				 		<div class="modal-footer">
				 			Total Price: Php {{ totalprice}} &nbsp;
				 			<router-link to="/checkout" data-dismiss="modal" class="btn-btn-primary">checkout</router-link>
				 		</div>
				 	</div>
				 </div>
			</div>
		</div> --> 
		<div class="course-view">
			<div v-if="!loading">
				<template v-if="!course">
						 <div class="container">
						 	 <h1 class="d-padding">Sorry, course is not available!</h1>
						 </div>
				</template>
				<template v-else>
					<!-- Start of Breadcrumb -->
					<div class="breadcrumb">
						<div class="container">
							<ul class="list-unstyled">
								<li><button class="btn btn-back" v-on:click="goBack()">Go Back</button></li>
								<li><span>{{ course.title }}</span></li>
							</ul>
						</div>
					</div>
					<!-- End of Breadcrumb -->

				   <!-- Start of Course Info -->
					<section class="course-info">
						<div class="container">
							<div class="row">
									
								<div class="col-lg-8 col-md-6">


									<!-- Start of Course Banner -->
									<section class="course-banner">
										
											  <h1>{{ course.title }}</h1>
											  <p>{{ course.short_description }}</p>
									
									</section>
									<!-- End of Course Banner -->
									
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
											<img :src="`../images/${course.image}`" width="100%" />
										</div>
										<div class="course-widget">
											<div class="course-price">
												<!-- <h2><span>{{ course.discount_price | currency  }}</span>  <sup>{{ course.orig_price | currency  }}</sup></h2>
												<hr> -->

											</div>
											<div class="course-cart">
												<!-- <template v-if="!isPurchased">
													 <template>
														<router-link to="/cart" class="btn btn-primary btn-wide font-weight-bold inactive"> 
															Go to Cart
														</router-link>
													</template> -->
													<!-- <template>
														<button class="btn btn-primary btn-wide font-weight-bold" @click="addCart(course)" > 
															<span>Add to cart</span>
														</button>
													</template>
												</template> -->
												<!-- <template v-else>
													<router-link to="/my-courses/" class="btn btn-primary btn-wide font-weight-bold inactive"> 
															Go to Course
													</router-link>
												</template> --> 
												
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
	</div>
</template>

<script>
	import Preloader from '../loader/Preloader.vue';
	import { mapGetters, mapActions } from 'vuex';
	export default {
		name: 'view-course',
		components: { Preloader },
		data() {
			return {
				course: null,
				lessons: [],
				loading: true,
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
				access: [],
				userAccess: {},
				isPurchased: false,
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			courses() {
				return this.$store.getters.courses;
			},
			isLoggedIn() {
                return this.$store.getters.isLoggedIn;
            },
            
		},
		mounted() {

       		axios.get(`/api/courses/${this.$route.params.id}`, {})
       		     .then((response) => {
       		     		this.loading = false;
       		     		this.course = response.data.course
       		     })
       		     .catch((err) => {
       		     	console.log(err);
       		     })


       		axios.get(`/api/video-by-course/${this.$route.params.id}`)
				 .then((response) => {
				 	this.lessons = response.data.videos;
				 })
				 .catch((error) => {
				 	console.log(error);
				 })


			this.viewCart();
			let currentCarts = JSON.parse(localStorage.getItem('cart'));

			if(currentCarts) {

				let is_added_to_cart = currentCarts.find( item => parseInt(item.id) == this.$route.params.id);

			}
			//Check if item has been purchased
			//Check Course Access
			this.getCourseAccess();
			//this.getUserAccess();


		},
		methods: {

			...mapActions(['addInCart']),
			goBack() {
				window.history.back();
			},
			viewCart(){
				if(localStorage.getItem('inCart')) {
					this.carts = JSON.parse(localStorage.getItem('inCart'));
					this.badge = this.carts.length;
					this.totalprice = this.carts.reduce((total, item) => {
						return total + this.quantity  * item.price;
					}, 0) 

				}
			},
			addCart(pro) {

				this.cartadd.id = pro.id;
				this.cartadd.name = pro.title;
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
				localStorage.setItem('inCart', parsed);
				this.viewCart();
			}
		}
		
		

	}
</script>
<style scoped>
	.btn-back {
		background: #f6961e;
		color: #fff;
		border-color: #f6961e;
		border-bottom: 4px solid #f6961e;
		padding: 3px 12px;
	}
	.btn-back:hover { 
		border-color: #f6961e;
		border-bottom: 4px solid #c07618;
	}
</style>