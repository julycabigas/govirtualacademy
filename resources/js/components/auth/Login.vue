<template>
	<div class="login-section">
		<div class="loading-wrapper loading-wrapper--small" id="loader-front" v-bind:class="{ 'show':loading == true }">
			<div class="loading">
				<Preloader />
			</div>
		</div>
		<!-- End of Loading -->

		<div class="container">
			<!-- Start of Login -->
			<div class="custom-content-area row">
				<div class="col-lg-7">
					<div class="text-block">
						<h1 class="font-weight-bold">Welcome to the gates of endless possibilities!</h1>
						<p>Start the day with a smile while aiming high. Enjoy every Virtual Academy PH tutorials experience and shine with the newly polished skills. </p>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="msg-alert">
						<template v-if="authError">
							<div class="alert alert-danger" v-if="message">
								{{ message }}
							</div>
						</template>
						<template v-else>
							<div class="alert alert-success" v-if="message">
								{{ message }}
							</div>
						</template>
						
					</div>
					<div class="area-form">
						<form @submit.prevent="authenticate">
							<div class="form-group">
								<label for="email">Email:</label>
								<input type="email" v-model="form.email">
							</div>
							<div class="form-group">
								<label for="password">Password:</label>
								<input type="password" v-model="form.password">
							</div>
							<div class="form-group pt-3 clearfix">
								<input type="submit" value="SUBMIT"  class="form-control btn btn-primary float-right">
							</div>
							<hr>
							<div class="form-group row">
									<div class="col">
										<router-link to="/register" class="dark font-weight-bold">Sign Up</router-link>
									</div>
									<div class="col text-right">
										<router-link to="/forgot-password" class="dark font-weight-bold">Forgot Password</router-link>
									</div>
								</div>
							<!-- <div class="form-group" v-if="authError">
								<p class="error">
									{{ authError }}
								</p>
							</div> -->
						</form>
					</div>

				</div>
			</div>
			<!-- End of Login -->
		</div>
	</div>
</template>
<script>
	import {login} from  '../../helpers/auth';
	import Preloader from '../loader/Preloader.vue';
	export default {
		name: 'login',
		components: { Preloader },
		data() {
			return {
				form: {
					email: '',
					password: ''
				},
				error: null,
				message: null,
				loading: null
			}
		},
		created() {
			if( this.$route.query.message == 'success') 
			{
				this.message = 'You have successfully registered. You may log in now!';
			}	
		},
		methods: {
			authenticate() {
				this.loading = true;
				this.$store.dispatch('login');
				
				login(this.$data.form)
				    .then((res) => {
				    	this.loading = false;
				    	this.$store.commit("loginSuccess", res);
				    	this.$router.push({path: '/'});
				    })
				    .catch((error) => {
				    	this.loading = false;
				    	this.$store.commit("loginFailed", {error});
				    	this.message = this.authError;
				    })
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
	.login {
	   margin-top: 40px;
	}
	.error {
		text-align: center;
		color: red;
	}
	.custom-content-area .text-block {
	    padding-left: 0;
	    padding-right: 60px;
	    line-height: 2;
	}
</style>