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
			<div class="area-form pt-3">
					<div class="top-nav mb-2 pt-2 text-right">
						<router-link to="/my-profile/add-purchase" class="btn btn-primary">Add a purchase</router-link>
					</div>
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Training</th>
								<th>Amount</th>
								<th>Payment Method</th>
								<th>Status</th>
								<th width="250">Date</th>
								<th width="150">Action</th>
						    </tr>
						</thead>
						<tbody>
							<tr v-for="(purchase, index) in purchases" :key="index">
								<td>{{ purchase.display_name }}</td>
								<td>{{ purchase.amount | currency }}</td>
								<td>{{ purchase.payment_method }}</td>
								<td>{{ purchase.status }}</td>
								<td>{{ purchase.created_at }}</td>
								<td v-if="purchase.status == 'pending'">
									<router-link :to="`/my-profile/purchase/delete/${ purchase.id }`" class="btn btn-sm btn-primary"> Delete</router-link>
								</td>
								<td v-else>
									
								</td>
							</tr>
						</tbody>
					</table>
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
				purchases: {},
				purchaseID: null,
				
			}
		},
		created() {
			this.getPurchases();
		},
		mounted() {
			if( this.isMentor || this.isEmployer ) {
				this.$router.push('/');
			}
		},
		methods: {
			getPurchases() {
				axios.get(`/api/mypurchases/${this.currentUser.id}`, {
							headers: {
								"Authorization": `Bearer ${this.currentUserToken}`
							}
						})
						.then((response) => {
						
							this.purchases = response.data.purchases;
						})
						.catch((error) => {
							console.log(error);
						})
			}
			
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
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