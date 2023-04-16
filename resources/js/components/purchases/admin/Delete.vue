<template>
	<div class="inner-info page-content">
		<div v-if="purchase">		
			<div class="area-form pt-3">
				<form @submit.prevent="deletePurchase">
					   <p>Purchase ID: <strong>{{ purchase.id }}</strong></p>
					   <p>Payment Method: <strong>{{ purchase.payment_method }}</strong></p>
					   <label for="note">Reason for deleting:</label>
					   <input type="text" v-model="note" />
					   <input type="submit" class="mt-3 btn btn-primary btn-sm" value="Delete">
				</form>
			</div>			
		</div>
		<div v-else>
			Sorry, we can't find your purchase.
		</div>
		<!-- Start of Breadcrumb -->
		<div class="breadcrumb mt-5 mb-3">
			<div class="container">
				<ul class="list-unstyled">
					<li><router-link to="/admin/purchases">All Purchases</router-link></li>
					<li><span>Purchase</span></li>
				</ul>
			</div>
		</div>
		<!-- End of Breadcrumb -->
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
				note:  null,
				
			}
		},
		created() {
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
							console.log(response.data.purchase);
							this.purchase = response.data.purchase;
						})
						.catch((error) => {
							console.log(error);
						})
			},
			deletePurchase() {

				axios.post(`/api/purchases/update/${this.$route.params.id}`, {
							'status' : 'deleted',
							'notes' : this.note,
							'user_id' : this.$data.purchase.user.id,
							'amount' : this.$data.purchase.amount,
							'payment_method' : this.$data.purchase.payment_method,
							'access_id' : this.$data.purchase.access_id
						}, {
						  headers: {
						  	 "Authorization" : `Bearer ${this.currentUserToken}`
						  }
						})
						.then((response) => {
							this.$router.push('/admin/purchases');
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