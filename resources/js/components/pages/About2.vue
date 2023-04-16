<template>
  <div class="page-wrapper page-about-landing">
	  	<div class="bg-overlay">
			<section class="intro intro-start module">
					<div class="container">
						<h1>How to get an online job as <span>Virtual Assistant</span> in Digital Marketing?</h1>
						<p>The COVID-19 changes the world and affects how people run their businesses and do their work. Sad to say,
					there are lots of people losing their jobs right now. You might be one of them and you’re here hoping to get an online job.</p> 
						<p>Let me introduce you to <strong>Virtual Academy PH.</strong>  Our mission is to help Filipinos become digital marketing specialists and find an online job.
					Founded by two Filipinos, July and Jurie, who have worked as digital marketers for 5 years now, they will be teaching you all the skills
					they have learned.</p>
 
						<router-link class="btn btn-primary" to="register/">REGISTER NOW</router-link>
				</div>
			</section>
			<section class="about-company module">
				<div class="container">
					<img :src="'images/about/founder.png'" alt="founder" width="100%" height="auto">
					<h2>Who We Are</h2>
					<p>July is currently working as a web developer, graphic designer and a digital marketer, while Jurie is a CRM specialist, a team leader, and an online marketing guru. </p>
					<p>Our combined experience of more than 5 years has taught us a lot about digital marketing. Of course, at first, we only knew the basics and it took us a while to absorb the
					concept but you know Filipinos, we never back down to any challenge so we continue the journey.</p>
					<p>Over the years, we have enhanced our skills, we learned a lot and have helped clients from Australia, Canada and US on marketing their business online.
					Working with international clients has given us a lot of opportunities.
					Jurie had a trip to Australia recently to meet the client. July was able to build two houses, one just recently finished.</p>
					<img :src="'images/about/jurie.png'" alt="jurie" width="100%" height="auto">
				</div>
			</section>
			<section class="about-company proof-of-payment module">
			<div class="container">
					<h3 clas="mb-3">See the proof from the past until present earnings</h3>
					
					<div class="pt-3">
						<img :src="'images/about/paypal.png'" alt="Paypal payment" width="100%" height="auto">
					</div>
			</div>
			</section>   
			<section class="intro why module">
				<div class="container">
					<h2>What Qualifications Do You Need  to <br><span>Become A Virtual Assistant in Digital Marketing?</span></h2>
					<p> You don’t need any degree or a college diploma to become one. All you need is the right
					measure of effort in the right direction. The only eligibility to get into the field of digital marketing is the
					right skill set and knowledge that the client asks for. As a matter of fact, July is a college dropout.</p>
				</div>
			</section>
			<section class="list ">
			<h4>We just need you to do the following:</h4>
				<ul>
					<li>A laptop or PC</li>
					<li>Able to spend  at least 2 hours per day to learn</li>
					<li>Dedication and commitment to learn </li>
					<li>Always ask questions if you need some support</li>
					<li>Stop procrastinating</li>
				</ul>
			</section>
			<section class="reviews module mb-5">
				<div class="container">

						<h6 class="text-center">We want to bring the best in you and come out with positive results.<br> Just like the below students we have:</h6>
						<div class="row">
							<div class="col-sm-6 col-md-6">
								<iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fisrael.dimagiba.82%2Fposts%2F747350362444687&width=100%" width="100%" height="161" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
							</div>
							<div class="col-md-6 col-sm-6">
								<iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fkatrinajit.vaja%2Fposts%2F10216920602834129&width=100%" width="100%" height="237" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
							</div>
						</div>

						<h3 class="text-center mt-5 review-heading-mid">Our client's testimonials and comments working as a virtual assistant</h3>
						<div class="row">
							<div class="col-md-6">
								<iframe src="https://player.vimeo.com/video/410268514" width="auto" height="600" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
							</div>
							<div class="col-md-6">
								<img :src="'images/about/upwork.png'" alt="VA PH client's comment" width="100%" height="auto"> 
							</div>
							<div class="col-md-12">
								<img :src="'images/about/upwork3.png'" alt="VA PH client's comment" width="100%" height="auto">  
							</div>
							<div class="col-md-12 mt-3">
								<img :src="'images/about/client-comments.png'" alt="VA PH client's comment" width="100%" height="auto"> 
							</div>
						</div>
						
						
				</div>
			</section>
			<section class="intro why">
				<div class="container">
					<h2>What You'll <span>Learn</span> From This Training?</h2>
					<p>This is an online training which you can access on our website. You can learn anywhere at anytime.</p>
				</div>
			</section>
			<section class="list list-learning">
				<ul>
					<li>Social media management <span>(Worth Php 1290)</span></li>
					<li>Website hosting and administration <span>(Worth Php 1990)</span></li>
					<li>Email Marketing <span>(Worth Php 990)</span></li>
					<li>Graphic Designing</li>
					<li>CRM and SEO <span>(Worth Php 2990)</span></li>
					<li>Ecommerce  <span>(Worth Php 990)</span></li>
					<li>Online Advertising <span>(Worth Php 990)</span></li>
					<li>Booking management</li>
					<li>Integrations and Analytics <span>(Worth Php590)</span></li>
				</ul>
			</section>
			<section class="intro why module">
				<div class="container">
					<h2>How to Start Learning?</h2>
					<p>Purchase the Virtual Assistant training for P2990 only. Once payment has been made you can contact us through our messenger or email so we can give you access. 
					If you want a demo, you can register first and then request a demo to our support via FB messenger. 		
					</p>
					<div class="link-to-training text-align-center mb-4">
						<router-link class="btn btn-primary" :to="`trainings/${training.id}`">PURCHASE NOW</router-link>
						<router-link class="btn btn-secondary" to="/register">REQUEST A DEMO</router-link>
					</div>
				</div>
			</section>
			<section class="intro why why-v2 mt-2 mb-4">
				<div class="container">
					<h2>What Happen  to Me After The Training?</h2>
					<p>Once you have finished the training, we will give you a certificate of completion that you can use to apply an online job. 
						We also have formed a VA deployment team to help you find a job. For more info, please don't hesitate to contact us. 		
					</p>
				</div>
			</section>

		
		</div>

    </div><!-- .end page wrapper -->

</template>

<script>
	import carousel from 'vue-owl-carousel';
	import PayPal from 'vue-paypal-checkout';
	import  {login} from  '../../helpers/auth';
	import Preloader from '../loader/Preloader.vue';
	export default {
		name: 'about-2',
		components: {
		    PayPal,
			Preloader,
			carousel
		},
		data() {
			return {
				featured_course: [],
				va_course: {},
				reviews: [],
				course_is_loading: false,
				va_is_loading: false,
				testimonial_is_loading: false,
				loading: true,
				training: {},
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
		},
		mounted() {

			// Get Virtual Assistant Course	
			axios.get('/api/virtual-assistant-course')
				.then((response) => {
					this.va_is_loading = true;
					this.va_course = response.data.courses;
					this.loading = false;
					this.training = response.data.training;
				})
				.catch((error) => {
					console.log(error);
			})	
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
			isLoggedIn() {
                return this.$store.getters.isLoggedIn;
            },
		}
	}

</script>
<style scoped>
section.reviews {
	margin-top: 30px;
	padding-bottom: 50px;
}
section.reviews img {
    box-shadow: 0 15px 23px 0 #f1f0f0;
}
.list-learning {
	margin-top: 20px;
}
section.list.list-learning li {
    font-size: 1.2em;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
}
section.list.list-learning li span {
    font-size: 15px;
}
.why-v2 {
	margin-top: 70px !important;
	margin-bottom: 40px !important;
}
</style>