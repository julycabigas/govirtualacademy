<template>
   <div class="page-wrapper course-page">
		<!-- Start of Course-->
		<section id="courses-page" class="d-padding courses-page-content">
			<div class="container">
                <div id="loader-front" v-if="loading">
                    <div class="loading">
                        <Preloader />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">

                        <template v-if="singleBundle">
                            <template v-if="isActiveBundle">

                                <div class="inner-training">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="training-content">
                                                <h2 class="font-weight-bold">{{ singleTraining.display_name }}</h2>
                                                <p>{{ singleTraining.description }}</p>

                                                <div class="price" v-if="singleTraining.id != 7">
                                                    <span>From {{ singleTraining.reg_price | currency }}</span>
                                                    <strong class="discounted-price">{{ singleTraining.discount_price | currency }}</strong>
                                                </div> 

                                                <div class="action-button">

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
                                    <div class="col-sm-12" v-for="course in singleBundle" v-bind:key="course.id">
                                            <!-- Single Course Item Start -->
                                            <router-link :to="`/courses/${course.id}`" class="single-course-item">	
                                       
                                                <!-- /.single-thumb-area -->
                                                <div class="course-content">
                                                    <h3>{{ course.title }}</h3>
                    
                                                    <!-- <div class="course-meta">
                                                        <template v-if="course.rating">
                                                            <div class="rating"><star-rating :inline="true" :star-size="20" :read-only="true"  :increment="0.01" :show-rating="false" :rating="course.rating"></star-rating> <span class="info"><strong>{{ course.rating }}</strong> ({{ course.total_students }})</span></div>
                                                        </template>
                                                    </div> -->
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
                    <div class="col-md-5" v-if="isActiveBundle">

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
                            <template v-if="status == 'approved'"> 
                                   <div class="text text-success">Payment was successful. </div> 
                                   <strong v-if="!isLoggedIn">Next is creating your account. Fill up the form below:</strong>
                            </template>
                            <template v-else>

                                   <h4 class="step-title">Pay Now</h4>
                                    <template>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="content-body">
                                                    <table class="table table-striped text-left">
                                                        <tbody>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th width="100" class="text-right">Price</th>
                                                                
                                                            </tr>
                                                            <tr v-if="singleTraining" >
                                                                <td>{{ singleTraining.display_name }}</td>
                                                                <td class="text-right">Php {{ singleTraining.discount_price }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="content-footer text-right" id="grandtotal">
                                                    <span><span>Total Price:</span> Php {{ singleTraining.discount_price }}</span> 
                                                </div>
                                                <div class="payment">
                                                    <PayPal
                                                    :amount="totalprice"
                                                    currency="PHP"
                                                    :client="credentials"
                                                    :button-style="myStyle"
                                                    v-on:payment-authorized="paymentAuthorized"
                                                    v-on:payment-completed="paymentCompleted"
                                                    v-on:payment-cancelled="paymentCancelled"
                                                    >
                                                    </PayPal>
                                                    <div class="text text-danger"> For your Debit/Credit payments, Simply click the button above to pay</div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                            </template>

                            <template v-if="!isLoggedIn && status == 'approved'">
                                <form @submit.prevent="authenticate">
                                
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="email" v-model="user.email" class="form-control" placeholder="Email Address*">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password:</label>
                                            <input type="password" v-model="user.password" class="form-control" placeholder="Password*">
                                        </div>
                                        <div class="form-group pb-2 txt-align-right">
                                            <input type="submit" value="Register Now"  class="btn btn-primary">
                                        </div>
                                
                                </form> 
                            </template>

                        </div>

                        <div class="order-form" v-if="status != 'approved'">
                                <h4>For Philippines, other options to pay:</h4>
                                <div class="card">
                                    <div class="card-header" id="headingThree">
                                        <h5 class="mb-0">
                                            Palawan / Cebuana / Mlhulier
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        Kindly read Palawan payment instructions below:<br>

                                        1.  Go to the nearest Palawan Express Padala Branch.<br>
                                        2. Pay the fee according to your chosen package to the following details:<br>
                                            • Receiver Name: Jurellie Catalan<br>
                                            (NOTE: Please make sure you leave the branch with the CORRECT SPELLING)<br>
                                            • Mobile Number: 09267276966<br>
                                        3. Take a photo of the payment slip/screenshot of payment confirmation and send it to support@virtualacademy.ph.<br>
                                        4. We will verify your payment within 24 hours.

                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingFive">
                                        <h5 class="mb-0">
                                            Gcash / Coins.PH / Paymaya
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p>Kindly follow the instructions below:<br>

                                        <h6 class="mt-4">For Coins.PH</h6>    
                                        1. Please send the payment to 0926 727 6966 then on the notes, put your email address and your full name<br>

                                        <h6 class="mt-4">For Paymaya</h6>    
                                        1. Please send the payment to 0923 173 6505 then on the notes, put your email address and your full name<br>

                                        <h6 class="mt-4">For Gcash</h6>    
                                        1. Please send the payment to 0965 386 3033 then on the notes, put your email address and your full name<br>

                                        <h6 class="mt-4">Next Steps</h6>   
                                        2. Take a photo of the payment slip/screenshot of payment confirmation and send it to support@virtualacademy.ph.<br>

                                        3. We will verify your payment within 24 hours.</p>

                                        <br>

                                        
                                    </div>
                                  
                                </div>   
                                <div class="card">
                                    <div class="card-header" id="headingFive">
                                        <h5 class="mb-0">
                                            BPI
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p>Kindly read BPI payment instructions below:<br>

                                        ***** HOW TO PAY THRU BPI *****<br>

                                        1. Deposit your payment to this account:<br>

                                        • Account Name: Jurellie Catalan<br>

                                        • Account Number: 9119285132<br>

                                        2. Take a photo of the payment slip/screenshot of payment confirmation and send it to support@virtualacademy.ph.<br>

                                        3. We will verify your payment within 24 hours.</p>

                                        <br>

                                        
                                    </div>
                                  
                                </div>    

                            
                        </div>

                    </div>
                </div>
		    </div>
		</section>
		<!-- End of Course -->
   </div>
</template>

<script>
    import {login} from  '../../helpers/auth';
	import carousel from 'vue-owl-carousel';
	import PayPal from 'vue-paypal-checkout';
	import Preloader from '../loader/Preloader.vue';
	import { mapActions } from 'vuex';
	export default {
		name: 'courses',
		components: { 
            carousel,
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
                id: '',
                userID: '',
                errors: null,
                myStyle: {
                    
                    label: 'checkout',
                    size:  'medium',
                    shape: 'rect',
                    color: 'blue'
                    
                }
            }

		},
		computed: {
			authError() {
				return this.$store.getters.authError;
			},
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
        watch: {
            changeId() {
               this.id = this.$route.params.id;
               console.log('test');
            },
            '$route': {
                handler: 'getBundleCourse',
                immediate: true // runs immediately with mount() instead of calling method on mount hook
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
            if(this.isLoggedIn) {
                this.user = this.currentUser();
            }
            this.getBundleCourse();
        },
		methods: {
			...mapActions(['addInCart']),
			getBundleCourse() {

				axios.get(`/api/single-bundle/${this.$route.params.id}`)
						.then((response) => {
                            console.log(response.data);
							this.singleBundle = [];
							this.singleBundle = response.data.courses;
							this.singleTraining = response.data.training;
							this.isActiveBundle = response.data.hasCourses;
                            this.loading = false;
                            this.totalprice = response.data.training.discount_price;
						})
						.catch((error) => {
							console.log(error);
							this.error = error.message;
						})
            },
            paymentAuthorized: function (data) {
	          
	        },
	        paymentCompleted: function (data) {

                  this.status = data['state'];
                  this.user.email = data['payer']['payer_info']['email'];
                  
                    if(this.isLoggedIn) {
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
                                 console.log(this.status);
                                this.$router.push('/thank-you');
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }
                    
                  
	        },
	        paymentCancelled: function (data) {
	          console.log(data);
	        },
	        authenticate() {

		
				axios.post('/api/users/create-from-purchase', this.$data.user)
					.then((response) => {
						
					
						if(response.data.success) {
							this.errors = null;
                            this.message = response.data.data;
                            this.userID = response.data.student.id;
							//this.$router.push({path: '/checkout', query: { message: 'success'} });

							this.$data.form.email = this.user.email;
							this.$data.form.password = this.user.password;
							this.$store.dispatch('login');
				
							login(this.$data.form)
							    .then((res) => {
							    	
							    	this.$store.commit("loginSuccess", res);
                                    //this.$router.push({path: `/trainings/${this.$route.params.id}`});
                                    if(response.data.student.id) {
                                            axios.post('/api/purchases/new', {
                                                        'user_id' : response.data.student.id,
                                                        'status'  : this.status, 
                                                        'amount'  : this.totalprice,
                                                        'payment_method': 'paypal'
                                                }, {
                                                headers: {
                                                    "Authorization" : `Bearer ${this.currentUser.token}`
                                                }
                                                })
                                                .then((response) => {
                                                    console.log(this.status);
                                                    this.$router.push('/thank-you');
                                                })
                                                .catch((error) => {
                                                    console.log(error);
                                                });
                                    }


                                       
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
	
	}

</script>
<style scoped>
    .text-success {
        color: #198848 !important;
        margin-bottom: 10px;
        background: #98efbd;
        padding: 5px 10px;
        line-height: 1.2;
        border-radius: 4px;
    }
    .text-danger {
        font-size: 14px;
        text-align: right;
        position: relative;
        right: 0;
        left: auto;
    }
    .paypal-button {
        text-align: right;
        margin-bottom: 20px;
    }
	.bundle-courses .row {
	    justify-content: flex-start;
	}
	.courses-page-content {
	    background: #f5f5fa;
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
    .single-course-item .course-content h3 {
        margin: 10px 0 15px;
        min-height: auto;
    }
    .single-course-item {
        margin-bottom: 10px;
        border: 1px solid #e9e9ef;
    }
    .course-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 7px;
        padding-bottom: 0px;
        border-top: 1px solid #f9f7f7;
        min-height: auto;
    }
    .form-wrapper {
        padding: 15px 15px;
        background: #fff;
        margin-bottom: 20px;
    }
	.action-button .btn {
		background: #4CAF50;
    	border: 1px solid #4caf50;
    }
    .order-form {
        padding: 15px;
        background: #fff;
        box-shadow: 0 2px 5px #ebebeb;
    }
    strong.discounted-price {
        color: #e75d3a;
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