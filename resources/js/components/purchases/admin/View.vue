<template>
	<div class="purchase-view">
			<!-- Start of Breadcrumb -->
			<div class="breadcrumb">
				<div class="container">
					<ul class="list-unstyled">
						<li><router-link to="/admin/purchases/">Purchases</router-link></li>
						<li><span>Purchase Id: {{ purchase.id }}</span></li>
					</ul>
				</div>
			</div>
			<!-- End of Breadcrumb -->
			<br>
			<div class="message alert alert-success" v-if="message">{{ message }}</div>
		  <div class="text-group">
		  	 <label for="user">User ID</label>
		  	 <div><strong>{{ user.firstname }} {{ user.lastname }}</strong></div>
		  </div>
		  <div class="text-group">
		  	 <label for="user">Training</label>
		  	 <div><strong>{{ training.display_name }}</strong></div>
		  </div>
		  <div class="text-group">
		  	 <label for="user">Training</label>
		  	 <div><strong>{{ training.display_name }}</strong></div>
		  </div>
		  <div class="text-group">
		  	 <label for="user">Status</label>
		  	 <div><strong>{{ purchase.status }}</strong></div>
		  </div>
		  <div class="text-group">
		  	 <label for="user">Payment Method</label>
		  	 <div><strong>{{ purchase.payment_method }}</strong></div>
		  </div>
		  <div class="text-group">
		  	 <label for="user">Amount</label>
		  	 <div><strong>{{ purchase.amount }}</strong></div>
		  </div>
		  <div class="text-group">
		  	 <label for="user">Notes</label><br>
		  	 <div v-html="purchase.notes"></div>
		  </div>
		  <form @submit.prevent="approve">
				
				<div class="form-group">
					<input type="hidden" name="status" v-model="status" />
				</div>

				<input type="submit" value="Approve" class="btn btn-primary">
			</form>	
	</div>	
</template>
<script>
	export default {
		name: 'purchase-view',
		data() {
			return {
				purchase: {},
				user: {},
				training: {},
				status: '',
				access_id: ''
			}
		},
		mounted(){
			this.getSinglePurchase();
		},
		methods: {
			getSinglePurchase() {
				axios.get(`/api/purchases/${this.$route.params.id}`,{
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					  .then((response) => {
		
						  this.purchase = response.data.purchase;
						  this.user = response.data.purchase.user;
						  this.training = response.data.purchase.access;
					  })
					  .catch((error) => {
					  	  console.log(error);
					  });
			},
			approve() {

				axios.post(`/api/approve-payment/update/${this.$route.params.id}`,  {
						'access_id' :  this.purchase.access_id,
						'user_id' : this.purchase.user_id,
						'status' : 'approved',
			
					}, {
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					.then((response) => {
						this.message = response.data.message;
						this.purchase = {};
					})
					.catch((error) => {
						console.log(error);
					});

			},
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		}
	}
	
</script>
<style scoped>
.text-group {
	margin-bottom: 10px;
}
.text-group label {
    margin: 0;
}
.breadcrumb {
    padding: 0;
    margin: 0;
    border: 0;
    border-radius: 0;
    background: #ffffff;
}
.breadcrumb .container {
    padding: 0;
}
.breadcrumb .container a:hover {
	color: #222;
}
</style>