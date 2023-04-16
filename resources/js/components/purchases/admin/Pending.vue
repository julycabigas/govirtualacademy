<template>
	    <div class="home-content d-padding">

		<div class="container">
			<div class="row">
				<div class="col-lg-2 col-md-12">
					
					<Sidebar/>

				</div>
				<div class="col-lg-10 col-md-12">
					
					<!-- Start of Home Main Content -->
					<div class="home-main-content">
						<div class="card">
							<div class="card-header">
								Purchases

							</div>
							<div class="card-body">

									<div>
								       <table class="table table-striped">
									       	<thead>
									       		<th>Date</th>
									       		<th>Student</th>
									       		<th>Price</th>
									       		<th>Payment Method</th>
									       		<th>Action</th>
									       	</thead>
									       	<tbody>
									       		<template v-if="!postData">
									       			<tr>
									       				<td colspan="4" class="text-center">No courses available</td>
									       			</tr>
									       		</template>
									       		<template v-else>
									       			<tr v-for="purchase in postData.data" :key="purchase.id">
									       				<td>{{ purchase.created_at }}</td>
									       				<td>{{ purchase.user.firstname }} {{ purchase.user.lastname }}</td>
									       				<td>{{ purchase.amount }}</td>
									       				<td width="200">{{ purchase.payment_method }}</td>
									       				<td width="200">
									       					<router-link :to="`/admin/purchases/${purchase.id}`" class="btn btn-custom btn-sm btn-primary">View</router-link>
									       					<router-link :to="`/admin/purchases/${purchase.id}`" class="btn btn-custom btn-sm btn-secondary">Approve</router-link>
															<router-link :to="`/admin/purchases/delete/${purchase.id}`" class="btn btn-custom btn-sm btn-success">Delete</router-link>
									       				</td>
									       			</tr>
									       		</template>	
									       	</tbody>
								       </table>
								       <pagination :data="postData" @pagination-change-page="getResults"></pagination>
									</div>

							</div>
						</div>
					</div>
					<!-- End of Home Main Content -->
					
				</div>
			</div>
		</div>
    </div>
</template>

<script>
import Sidebar from '../../home/Sidebar.vue';
	export default {
		name: 'list',
		components: {Sidebar},
		data() {
			return {
				postData: {}, 
			}
		},
		mounted() {
			this.getResults();
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		methods: {
			getResults(page = 1) {
				axios.get('/api/pending-purchases?page=' + page, {
						headers: {
							"Authorization": `Bearer ${this.currentUser.token}`
						}
					})
					.then(response => {
						this.postData = response.data.purchases;
					});
			}
		}
	}
</script>