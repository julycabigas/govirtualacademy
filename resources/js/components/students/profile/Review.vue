<template>
	<div class="inner-info page-content pt-5">
			<!-- Start of Breadcrumb -->
			<div class="breadcrumb mb-3">
				
					<ul class="list-unstyled">
						<li><router-link to="/my-profile/dashboard">My Profile</router-link></li>
						<li><span>Write A Review</span></li>
					</ul>
				
			</div>
			<!-- End of Breadcrumb -->
			<div class="area-form pt-3">
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
							<th>Testimony</th>
							<td>
								<vue-editor v-model="testimony.content"></vue-editor>
							
							</td>
						</tr>
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
	import { VueEditor } from 'vue2-editor';
	export default {
		name: 'add-testimony',
		components: {
			VueEditor
		},
		data() {
			return {
				testimony: {
					content: '',
					user_id: '',
					approve: false
				},
				form_errors: []
			}
		},
		created() {
			this.testimony.user_id = this.currentUserID;
			
		},
		mounted() {
			if( this.isMentor || this.isEmployer ) {
				this.$router.push('/');
			}
		},
		methods: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			updatePassword(e) {

			    if (!this.testimony) {
			       this.form_errors.push('Testimony is required.');
			    }

			    if(this.form_errors.length > 0) {
			    	e.preventDefault();
			    } else {

					axios.post(`/api/reviews/new/`, this.$data.testimony
					    , {
							headers: {
								"Authorization": `Bearer ${this.currentUserToken}`
							}
						})
						.then((response) => {
							this.testimony = response.data.testimony;
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
			isMentor() {
                return this.$store.getters.currentUser.role == 8 ? true: false;
            },
            isEmployer() {
                return this.$store.getters.currentUser.role == 9 ? true: false;
            }
		}
	}
</script>