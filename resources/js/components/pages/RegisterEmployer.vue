<template>
	<div class="register-section">
		<div class="container">
			<div class="custom-content-area row">
					<div class="col-lg-6">
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
					
						<div class="area-form">
							<h1 class="font-weight-bold">Employer Registration</h1>
							<p>Fields with * sign are required to be filled </p>
							<form @submit.prevent="authenticate">
								<div class="form-group">
									<label for="email" class="sr-only">Email:</label>
									<input type="email" v-model="user.email" placeholder="Email Address*">
								</div>
								<div class="form-group">
									<label for="password" class="sr-only">Password:</label>
									<input type="password" v-model="user.password" placeholder="Password*">
								</div>
								<hr>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="firstname" class="sr-only">First Name:</label>
											<input type="text" v-model="user.firstname" placeholder="First Name*">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="lastname" class="sr-only">Last Name:</label>
											<input type="text" v-model="user.lastname" placeholder="Last Name*">
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label for="address" class="sr-only">Address:</label>
									<input type="text" v-model="user.address" placeholder="Address">
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="address" class="sr-only">Zipcode:</label>
											<input type="text" v-model="user.zipcode" placeholder="Zipcode">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="city" class="sr-only">City:</label>
											<input type="text" v-model="user.city" placeholder="City">
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="province" class="sr-only">Province:</label>
									<select v-model="user.province">
										<option value="" selected>Select Province</option>
										<option v-for="(province, index) in provinces" :key="index" value="province">{{ province}}</option>
									</select>
								</div>
								<div class="form-group">
									<label for="phone" class="sr-only">Mobile No.:</label>
									<input type="text" v-model="user.phone" placeholder="Phone">
								</div>
								<div class="form-group pt-3">
									<input type="submit" value="SUBMIT"  class="btn btn-primary float-right">
								</div>
								<div class="form-group" v-if="authError">
									<p class="error">
										{{ authError }}
									</p>
								</div>
							</form>
						</div>
					
					</div>
					<div class="col-lg-6">
						<div class="text-block mt-4">
							<h4>Register as a Student, Employer or Mentor</h4>
							<p>Register NOW. Open the door to greatness. Simple and stress free registration process with full security.</p>
							
							<p>For employers who are looking for virtual assistant to hire or for mentors who are looking for coaching job register below.</p>				
							<p style="margin-top: 30px;">
								 <router-link to="/register" class="btn btn-tertiary">Register as Student</router-link>
								 <router-link to="/register-mentor" class="btn btn-secondary">Register as Mentor</router-link>
							</p>
						</div>
					</div>
				</div>	

		</div>


	</div>
</template>
<script>
	import  {login} from  '../../helpers/auth';
	import Preloader from '../loader/Preloader.vue';
	export default {
		name: 'login',
		components: { Preloader },
		data() {
			return {
				user: {
					email: '',
					password: '',
					province: '',
					city: '',
					zipcode: '',
					address: '',
					firstname: '',
					lastname: '',
					role: 9,
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
				message: null,
				loading: null
			}
		},
		methods: {
			authenticate() {
				this.loading = true;
				axios.post('/api/users/new', this.$data.user)
					.then((response) => {
						this.loading = false;
					
						if(response.data.success) {
							this.errors = null;
							this.message = response.data.data;
							this.user = [];


							this.$router.push({path: '/login', query: { message: 'success'} });
						} else {
							
							this.message = null;
							this.errors = response.data.data;
						}
					})
					.catch(error => console.log(error) )
			}
		},
		computed: {
			authError() {
				return this.$store.getters.authError;
			}
		}
	}
</script>
<style scoped>
	.register-section {
		 padding: 50px 0;
	}
	.login {
	   margin-top: 40px;
	}
	.error {
		text-align: center;
		color: red;
	}
	.footer-top-area {
	    display: none;
	}
	.banner:after {
		display: none;

	}
	.page-banner {

		min-height: 150px;
	}
	.area-form .row {
		margin-left: -5px;
		margin-right: -5px;
	}
	.area-form .row > div {
		padding-left: 5px;
		padding-right: 5px;
	}
</style>