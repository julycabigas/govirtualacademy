<template>
	<div class="inner-info page-content pt-5">
		<!-- Start of Breadcrumb -->
		<div class="breadcrumb mb-3">
		
				<ul class="list-unstyled">
					<li><router-link to="/my-profile/dashboard">My Profile</router-link></li>
					<li><span>Purchase History</span></li>
				</ul>
	
		</div>
		<!-- End of Breadcrumb -->
		<div v-if="purchase">		
			<div v-if="currentUser.id == purchase.user.id">
				<div class="area-form pt-3">
			
						<form @submit.prevent="deletePurchase">
							   <p>Purchase ID: <strong>{{ purchase.id }}</strong></p>
							   <input type="submit" class="btn btn-primary btn-sm" value="Delete">
						</form>
				</div>			
			</div>
			<div v-else>
				Sorry, we can't find your purchase.
			</div>
		</div>
		<div v-else>
			Sorry, we can't find your purchase.
		</div>
	</div>
</template>
<script>
	import { VueEditor } from 'vue2-editor';
	export default {
		name: 'delete-purchase',
		components: {
			VueEditor
		},
		data() {
			return {
				purchase: {
					id: ''
				},
				purchaseID: null,
				
			}
		},
		mounted() {
			this.getPurchase();
		},
		methods: {
			getPurchase() {
				axios.get(`/api/purchases/${this.$route.params.id}`, {
							headers: {
								"Authorization": `Bearer ${this.currentUserToken}`
							}
						})
						.then((response) => {
						
							this.purchase = response.data.purchase;
						})
						.catch((error) => {
							console.log(error);
						})
			},
			deletePurchase() {
	
				axios.post(`/api/purchases/delete/${this.$route.params.id}`, {
						  headers: {
						  	 "Authorization" : `Bearer ${this.currentUserToken}`
						  }
						})
						.then((response) => {
							this.$router.push('/my-profile/purchases');
						})
						.catch((error) => {
							console.log(error);
						});
				
			}
			
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			currentUserToken() {
				return this.$store.getters.currentUser.token;
			},
		}
	}
</script>