<template>
	<div class="inner-info page-content pt-5">
			<!-- Start of Breadcrumb -->
			<div class="breadcrumb mb-3">
				
					<ul class="list-unstyled">
						<li><router-link to="/my-profile/dashboard">My Profile</router-link></li>
						<li><span>Change Password</span></li>
					</ul>
			
			</div>
			<!-- End of Breadcrumb -->
			<div class="form-area pt-3">
				<p v-if="form_errors.length">
				    <b>Please correct the following error(s):</b>
				    <ul>
				      <li v-for="error in form_errors">{{ error }}</li>
				    </ul>
				 </p>
				<!-- Start Form -->
				<form @submit.prevent="updatePassword">
					<table class="table table-striped">
						<tr>
							<th>Password</th>
							<td>
								<input type="password" 
									v-model="password" 
									placeholder="Password" 
									>
							</td>
						</tr>
						<!-- <tr>
							<th>Retype Password</th>
							<td>
								<input type="text" 
									v-model="confirm_password" 
									placeholder="Confirm Password" 
									class="form-control">
							</td>
						</tr> -->
						<tr>
							<th></th>
							<td>
								<input type="submit" value="Save Changes" class="btn btn-primary" >

							</td>
						</tr>
					</table>
				</form>
				<!-- End Form -->

			</div>
		
		
	</div>
</template>
<script>
	export default {
		name: 'edit-password',
		data() {
			return {
				password: '',
				confirm_password: '',
				form_errors: []
			}
		},
		methods: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			updatePassword(e) {
				// if(this.password && this.confirm_password) {
				// 	return true;
				// }

			    if (!this.password) {
			       this.form_errors.push('Password is required.');
			    }


			    if(this.form_errors.length > 0) {
			    	console.log('errors');
			    	e.preventDefault();
			    } else {
			    	console.log('true');
					axios.post(`/api/students/update-password/${this.currentUserID}`, { 
						  'password' :this.$data.password
					    }, {
							headers: {
								"Authorization": `Bearer ${this.currentUserToken}`
							}
						})
						.then((response) => {
							console.log(response.data);
							this.student = response.data.student;
							this.$router.push('/my-profile/dashboard');
						})
						.catch((error) => {
							console.log(error);
						})
			    }
				
			}
			
		},
		computed: {
			currentUserID() {
				return this.$store.getters.currentUser.id;
			},
			currentUserToken() {
				return this.$store.getters.currentUser.token;
			},
		}
	}
</script>