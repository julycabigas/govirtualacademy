<template>
	<div class="login-page">

		
		<!-- Start of Loading -->
		<div class="loading-wrapper loading-wrapper--small" v-bind:class="{ 'show':loading == true }">
			<div class="loading-inner">
					<Preloader />
			</div>
		</div>
		<!-- End of Loading -->
		
		<!-- Start of Login -->
		<div class="container pt-3">
			
			<div class="custom-content-area row">
				<div class="col-lg-7">
					<div class="text-block">
						<h1 class="font-weight-bold">Forgot Password</h1>
						<ul>
							<li>Enter either the email address or username on the account.</li>
							<li>Select Submit.</li>
							<li>Check your inbox for a password reset email.</li>
							<li>Click on the URL provided in the email and enter a new password.</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="msg-alert">
						<div class="alert alert-success" v-if="message">
							{{ message }}
						</div>
						<div class="alert alert-danger" v-if="error">
							{{ error }}
						</div>	
					</div>
					<div class="area-form">
						<form @submit.prevent="forgotPassword">
							<div class="form-group">
								<label for="email">Email:</label>
								<input type="email" v-model="form.email">
							</div>
							<div class="form-group pt-3">
								<input type="submit" value="SUBMIT"  class="form-control btn btn-primary" >
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- End of Login -->
	</div>
</template>
<script>
	import  {login} from  '../../helpers/auth';
	import Preloader from '../loader/Preloader.vue';
	export default {
		name: 'forgot-password',
		components: { Preloader },
		data() {
			return {
				form: {
					email: ''
				},
				error: null,
				message: null,
				loading: null
			}
		},
		methods: {
			forgotPassword() {
				this.loading = true;
				axios.post('api/forgot-password', this.$data.form)
					.then((response) => {
	
						this.loading = false;
						if(response.data.success) {
							this.error = null;
							this.message = response.data.data;
						} else {
							this.message = null;
							this.error = response.data.data;
						}
					})
					.catch((error) => console.log(error))
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
	.btn {
		line-height: 1;
	}
</style>