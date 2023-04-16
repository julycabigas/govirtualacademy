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
		<div class="custom-content-area row">
			<div class="col-lg-5">
				<div class="msg-alert">
					<div class="alert alert-success" v-if="message">
						{{ message }}
					</div>
					<div class="alert alert-danger" v-if="error">
						<div v-html="error"></div>
					</div>	
				</div>
				<div class="area-form">
					<form @submit.prevent="resetPassword">
						<div class="form-group">
							<label for="password" class="sr-only">Password:</label>
							<input type="password" id="password" v-model="form.password" placeholder="Password">
						</div>
						<div class="form-group">
							<label for="c_password" class="sr-only">Confirm Password:</label>
							<input type="password" id="c_password" v-model="form.confirm_password" placeholder="Confirm Password">
							<input type="hidden" v-model="form.token" class="form-control">
						</div>
						<div class="form-group pt-3">
							<input type="submit" value="SUBMIT"  class="form-control btn btn-primary" >
						</div>
					</form>
				</div>
			</div>
			<div class="col-lg-7">
				<h1 class="font-weight-bold">Password Reset</h1>
				<p>Enter New Password for your account.</p> 
			</div>
		</div>
		<!-- End of Login -->
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
				form: {
					password: '',
					confirm_password: '',
					token: this.$route.query.token
				},

				error: '',
				message: null,
				loading: null
			}
		},
		mounted() {
			console.log(this.$route.query.token);
		},
		methods: {
			resetPassword() {
				this.loading = true;	
				axios.post('api/reset-password', this.$data.form)
					.then((response) => {
						this.loading = false;
						if(response.data.success) {
							this.error = null;
							this.message = response.data.data;
						} else {
							this.message = null;
							console.log(response.data.data);
							let input_error = response.data.data;

							if(response.data.input)
						    {
								console.log('test');
								this.error = '';
								if( input_error.password ) {
									this.error += input_error.password[0] + '<br>';
								}
								if( input_error.confirm_password) {
									this.error += input_error.confirm_password[0];
								}
							} 
							else if( response.data.token ) 
							{	
								this.error = '';
								this.error = response.data.data;
							}
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