<template>
	<section class="checkout-section">
		<div class="container pt-3">
			<h1 class="pt-4  pb-3 font-weight-bold">Checkout</h1>
			<template v-if="!isLoggedIn">
				<h4 class="note">Create an account first or login to purchase</h4>
			</template>
			<div class="row" v-if="carts.length">
				<div class="col-md-6">
						<!-- Start of Login -->
						<div class="register pb-5">
								<!-- Start of Loading -->
								<div class="loading-wrapper loading-wrapper--small" v-bind:class="{ 'show':loading == true }">
									<div class="loading-inner">
										<Preloader />
									</div>
								</div>
								<!-- End of Loading -->
								<div class="msg-alert">
									<div class="alert alert-success" v-if="message">
										{{ message }}
									</div>
									<template v-if="errors != null">
										<div class="alert alert-danger" v-if="errors">
											<div v-for="(error, index) in errors" :key="index">
												{{ error[0] }}
											</div>
										</div>	
								    </template>
								</div>
								<div class="form-wrapper">	
									<form @submit.prevent="authenticate">
										<template v-if="!isLoggedIn">
											<div class="form-group">
												<label for="email">Email:</label>
												<input type="email" v-model="user.email" class="form-control" placeholder="Email Address*">
											</div>
											<div class="form-group">
												<label for="password">Password:</label>
												<input type="password" v-model="user.password" class="form-control" placeholder="Password*">
											</div>
										</template>
										<template v-else>
											<div class="form-group">
												<p>You are currently logged in as {{ user.firstname }} {{ user.lastname }}.</p>
											</div>
										</template>
										<hr>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="firstname">First Name:</label>
													<input type="text" v-model="user.firstname" class="form-control" placeholder="First Name*">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="lastname">Last Name:</label>
													<input type="text" v-model="user.lastname" class="form-control" placeholder="Last Name*">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="address">Address:</label>
											<input type="text" v-model="user.address" class="form-control" placeholder="Address">
										</div>
										<div class="form-group">
											<label for="address">Zipcode:</label>
											<input type="text" v-model="user.zipcode" class="form-control" placeholder="Zipcode">
										</div>
										<div class="form-group">
											<label for="city">City:</label>
											<input type="text" v-model="user.city" class="form-control" placeholder="City">
										</div>
										<div class="form-group">
											<label for="province">Province:</label>
											<select v-model="user.province" class="form-control">
												<option value="" selected>Select Province</option>
												<option v-for="(province, index) in provinces" :key="index" value="province">{{ province}}</option>
											</select>
										</div>
										<div class="form-group">
											<label for="phone">Mobile No.:</label>
											<input type="text" v-model="user.phone" class="form-control" placeholder="Phone">
										</div>
										<template v-if="!isLoggedIn">
											<div class="form-group pb-2">
												<input type="submit" value="Register Now"  class="btn btn-primary float-right">
											</div>
										</template>
										<!-- <div class="form-group" v-if="authError">
											<p class="error">
												{{ authError }}
											</p>
										</div> -->
									</form>
							    </div>
						</div>
						<!-- End of Login -->
				</div>
				<div class="col-md-6">
					<div class="content-body">
						<table class="table table-striped text-left">
			 				<tbody>
			 					<tr>
			 						<th>Name</th>
			 						<th width="100" class="text-right">Price</th>
			 						
			 					</tr>
			 					<tr v-for="(cart, n) in carts" v-bind:key="cart.id">
			 						<td>{{ cart.name}}</td>
			 						<td class="text-right">Php {{ cart.price}}</td>
			 					</tr>
			 				</tbody>
			 			</table>
					</div>
					<div class="content-footer text-right" id="grandtotal">
						<span><span>Total Price:</span> Php {{ totalprice }}</span> 
					</div>
					<div class="accordion" id="accordionPayment">
						  <div class="card">
						    <div class="card-header" id="headingOne">
						      <h5 class="mb-0">
						        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						          Debit/Credit
						        </button>
						      </h5>
						    </div>

						    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionPayment">
						      <div class="card-body">
						        For your Debit/Credit payments, simply click Paypal Checkout button below  and make sure you take a screenshot payment confirmation and click Return to Merchant.

						        <template v-if="isLoggedIn">
						            <PayPal
						              class="mt-2"
									  :amount="totalprice"
									  currency="PHP"
									  :client="credentials"
									  v-on:payment-authorized="paymentAuthorized"
						        	  v-on:payment-completed="paymentCompleted"
						              v-on:payment-cancelled="paymentCancelled"
									  >
									</PayPal>
								</template>
								<template v-else>
									<div class="mt-3 text text-danger">You must register or login before you can purchase</div>	
								</template>
						      </div>
						    </div>
						  </div>
						  <div class="card">
						    <div class="card-header" id="headingTwo">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						          Paypal
						        </button>
						      </h5>
						    </div>
						    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionPayment">
						      <div class="card-body">
						        	For your PayPal payments, simply click the Paypal Checkout button below and make sure you take a screenshot payment confirmation and click Return to Merchant.
						        	<template v-if="isLoggedIn">
							            <PayPal
							              class="mt-2"
										  :amount="totalprice"
									  	  currency="PHP"
										  :client="credentials"
										  v-on:payment-authorized="paymentAuthorized"
							        	  v-on:payment-completed="paymentCompleted"
							              v-on:payment-cancelled="paymentCancelled"
										  >
										</PayPal>
									</template>
									<template v-else>
										<div class="mt-3 text text-danger">You must register or login before you can purchase</div>	
									</template>
						      </div>
						    </div>
						  </div>
						  <div class="card">
						    <div class="card-header" id="headingThree">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						          Palawan
						        </button>
						      </h5>
						    </div>
						    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionPayment">
						      <div class="card-body">
						        Kindly read Palawan payment instructions below:<br>

								1.  Go to the nearest Palawan Express Padala Branch.<br>
								2. Pay the fee according to your chosen package to the following details:<br>
								• Receiver Name: JULY NINO E. CABIGAS<br>
								(NOTE: Please make sure you leave the branch with the CORRECT SPELLING)<br>
								• Mobile Number: 0923-173-6505<br>
								3. Take a photo of the payment slip/screenshot of payment confirmation and send it to support@virtualacademy.ph.<br>
								4. Log back in to your account adn go to www.virtualacademy.ph/checkout<br>
								5. Choose the payment method and click submit.
								6. We will verify your payment within 24 hours.

								<form @submit.prevent="addPalawan">
									<div class="message alert alert-success" v-if="message1">{{ message1 }}</div>
									<div class="form-group">
										<label for="description">Notes</label>
										<textarea  v-model="notes"></textarea>
									</div>

									<input type="submit" value="Purchase" class="btn btn-primary">
								</form>
						      </div>
						    </div>
						  </div>
						<!--   <div class="card">
						    <div class="card-header" id="headingFour">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">BDO</button>
						      </h5>
						    </div>
						    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionPayment">
						      <div class="card-body">
							        <p>Kindly read 7/11 payment instructions below:<br>

									1. Go to the nearest 7/11 store.<br>

									2. Tell the cashier you want to cash-in to a GCash account.<br>

									3. Pay the enrollment fee to this number according to your chosen package:<br>

									NUMBER: 0966-771-8796<br>

									4. Log back in to your account and go to www.spiike.io/checkout<br>

									5. We will verify your payment within 24 hours.</p>

								    <form @submit.prevent="addSevenEleven">
									<div class="message alert alert-success" v-if="message2">{{ message2 }}</div>
									<div class="form-group">
										<label for="description">Notes</label>
										<textarea  v-model="notes"></textarea>
									</div>

									<input type="submit" value="Purchase" class="btn btn-primary">
								</form>
						      </div>
						    </div>
						  </div> -->
						  <div class="card">
						    <div class="card-header" id="headingFive">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
						          BPI
						        </button>
						      </h5>
						    </div>
						    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionPayment">
							      <div class="card-body">
							        Kindly read BPI payment instructions below:<br>

									***** HOW TO PAY THRU BPI *****<br>

									1. Deposit your payment to this account:<br>

									• Account Name: JULY NINO E. CABIGAS<br>

									• Account Number: 1369241377<br>

									2. Take a photo of the payment slip/screenshot of payment confirmation and send it to support@virtualacademy.ph.<br>

									3. Log back in to your account and go to www.virtualacademy.ph/checkout<br>

									4. We will verify your payment within 24 hours.</p>


									<br>
									<form @submit.prevent="addBank">
										<div class="message alert alert-success" v-if="message3">{{ message3 }}</div>
	
										<div class="form-group">
											<label for="payment_method"><strong>Select the bank</strong></label>
											<select id="payment_method" style="display:none" v-model="payment_method">
												<option value="BPI" selected>Select</option>
												<option value="BPI">BPI</option>
												<!-- <option value="BDO">BDO</option> -->
											</select>
										</div>	
										<div class="form-group">
											<label for="description">Notes (Transaction No.)</label>
											<textarea  type="text" v-model="notes"></textarea>
										</div>

										<input type="submit" value="Purchase" class="btn btn-primary">
									</form>	

							      </div>
							    </div>
					  		</div>
					</div><!-- End of Accordion-->
				</div>
			</div>
			<div class="row" v-else>
				<div class="col-sm-12">
					<p>Cart is empty</p>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
	import PayPal from 'vue-paypal-checkout';
	import  {login} from  '../../helpers/auth';
	import Preloader from '../loader/Preloader.vue';
	export default {
		name: 'checkout',
		components: {
		    PayPal,
		    Preloader
		},
		data() {
			return {
				form: {
					email: '',
					password: ''
				},
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
				totalprice: '',
				credentials: {
			        sandbox: 'AW3YIXr1OYy53L-G63I117vIWEcKQxuUoyMtuhm-yEvPNjniunTCnkrEIQoiuOhkOMkoFjaUPj-Cjidh',
			        production: 'AWDyq2gKKQsRIcJeENYs_yx2TS7PMSqTYeh3N5O1GoxN2ervm1NddgVlNb71PkjpMIjrhlntKWohKIcd'
			    },
			    status: '',
			    amount: '',
			    user_id: '',
			    payment_method: '',
			    notes: '',
			    message: null,
			    message1: null,
			    message2: null,
			    message3: null,
			    bank: '',
			    purchse: {},
			    user: {
					email: '',
					password: '',
					province: '',
					city: '',
					zipcode: '',
					address: '',
					firstname: '',
					lastname: '',
					role: 6,
					phone: ''
				},
				provinces : [
				 'Abra','Agusan','Aklan','Albay','Antique','Apayao','Aurora',
				 'Basilan','Bataan','Batanes','Batangas','Benguet','Biliran','Bohol','Bukidnon','Bulacan',
				 'Cagayan','Camarines','Camiguin','Capiz','Catanduanes','Cavite','Cebu','Compostela Valley','Cotabato',
				 'Davao','Dinagat Islands','Guimaras','Ifugao','Ilocos','Iloilo','Isabela',
				 'La Union', 'Laguna','Lanao','Leyte','Maguindanao','Marinduque','Mindoro','Misamis','Mountain Province',
				 'Negros','Nueve Ecija','Nueva Vizcaya','Palawan','Pampanga','Pangasinan',
				 'Quezon','Quirino','Rizal','Romblon','Samar','Sarangani','Sibugay','Siquijor','Sorsogon','Sultan Kudarat',
				 'Sulu','Surigao','Tarlac','Tawi-Tawi','Zambales','Zamboanga'
				 ],
				errors: null,
				loading: null
			}
		},
		created() {
			this.viewCart();
			if(this.currentUser){
				this.user = this.currentUser;
			}

		},
		methods: {
			viewCart(){
				// if(localStorage.getItem('carts')) {
				// 	this.carts = JSON.parse(localStorage.getItem('carts'));
				// 	this.badge = this.carts.length;
				// 	this.totalprice = this.carts.reduce((total, item) => {
				// 		return total + this.quantity  * item.price;
				// 	}, 0) 

				// }
				this.carts = this.inCart;
				this.totalprice = this.carts.reduce((total, item) => {
					return total + this.quantity  * item.price;
				}, 0); 
			},
			paymentAuthorized: function (data) {
	          console.log(data);
	        },
	        paymentCompleted: function (data) {
		          localStorage.removeItem('carts');
		          this.carts = '';
		          this.status = data['state'];
		          
		          axios.post('/api/purchases/new', {
		          		     	'user_id' : this.currentUser.id,
								'status'  : this.status, 
								'amount'  : this.totalprice,
								'payment_method': 'paypal'
		          		}, {
						  headers: {
						  	 "Authorization" : `Bearer ${this.currentUser.token}`
						  }
						})
						.then((response) => {
							this.$router.push('/thank-you');
						})
						.catch((error) => {
							console.log(error);
						});
	        },
	        addPalawan() {
	        	
	        		let userID = this.currentUser.id;
	        		let Token = this.currentUser.token;

					$.each(this.carts, function(key, value) {

	        			axios.post('/api/purchases/new', {
		          		     	'user_id' : userID,
		          		     	'access_id' : value.id,
								'status'  : 'pending', 
								'notes'	  : this.notes,	
								'amount'  : value.price,
								'payment_method': 'Palawan Express'
		          		}, {
						  headers: {
						  	 "Authorization" : `Bearer ${Token}`
						  }
						})
						.then((response) => {
								localStorage.removeItem('carts');
				          		this.carts = '';
				          		
						})
						.catch((error) => {
							console.log(error);
						});

					});
					this.$router.push('/my-profile/purchases');
	        },
	        addSevenEleven() {
	        	
	        		let userID = this.currentUser.id;
	        		let Token = this.currentUser.token;

					$.each(this.carts, function(key, value) {

	        			axios.post('/api/purchases/new', {
		          		     	'user_id' : userID,
		          		     	'access_id' : value.id,
								'status'  : 'pending', 
								'notes'	  : this.notes,	
								'amount'  : value.price,
								'payment_method': '7/11'
		          		}, {
						  headers: {
						  	 "Authorization" : `Bearer ${Token}`
						  }
						})
						.then((response) => {
						})
						.catch((error) => {
							console.log(error);
						});

					});

					localStorage.removeItem('carts');
	          		this.carts = '';
	          		this.$router.push('/my-profile/purchases');					
	        },
	        addBank() {
	        	
	        		let userID = this.currentUser.id;
	        		let Token  = this.currentUser.token;
	        		let Bank   = this.payment_method;

					$.each(this.carts, function(key, value) {

	        			axios.post('/api/purchases/new', {
		          		     	'user_id' : userID,
		          		     	'access_id' : value.id,
								'status'  : 'pending', 
								'notes'	  : this.notes,	
								'amount'  : value.price,
								'payment_method': Bank
		          		}, {
						  headers: {
						  	 "Authorization" : `Bearer ${Token}`
						  }
						})
						.then((response) => {

						})
						.catch((error) => {
							console.log(error);
						});

					});
					localStorage.removeItem('carts');
	          		this.carts = '';
	          		this.$router.push('/my-profile/purchases');


	        },
	        paymentCancelled: function (data) {
	          console.log(data);
	        },
	        authenticate() {

				this.loading = true;
				axios.post('/api/users/new', this.$data.user)
					.then((response) => {
						this.loading = false;
					
						if(response.data.success) {
							this.errors = null;
							this.message = response.data.data;
							//this.$router.push({path: '/checkout', query: { message: 'success'} });

							this.$data.form.email = this.user.email;
							this.$data.form.password = this.user.password;
							this.$store.dispatch('login');
				
							login(this.$data.form)
							    .then((res) => {
							    	this.loading = false;
							    	this.$store.commit("loginSuccess", res);
							    	this.$router.push({path: '/checkout'});
							    })
							    .catch((error) => {
							    	this.loading = false;
							    	this.$store.commit("loginFailed", {error});
							    	this.message = this.authError;
							    })

						} else {
							
							this.message = null;
							this.errors = response.data.data;
						}
					})
					.catch(error => console.log(error) )
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			isLoggedIn() {
                return this.$store.getters.isLoggedIn;
            },
            authError() {
				return this.$store.getters.authError;
			},
			inCart() {
                return this.$store.getters.inCart
            }
		}
	}
</script>
<style scoped>
 .note {
 	font-family: "Roboto", sans-serif;
 	text-transform: uppercase;
 }
</style>