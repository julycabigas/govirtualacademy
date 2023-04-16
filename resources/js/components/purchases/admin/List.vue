<template>
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
	       				<td colspan="5" class="text-center">No purchases available</td>
	       			</tr>
	       		</template>
	       		<template v-else>
	       			<tr v-for="purchase in postData.data" :key="purchase.id">
	       				<td>{{ purchase.created_at }}</td>
	       				<td>{{ purchase.user.firstname }} {{ purchase.user.lastname }}</td>
	       				<td>{{ purchase.amount }}</td>
	       				<td width="200">{{ purchase.payment_method }}</td>
	       				<td width="250">
	       					<router-link :to="`/admin/purchases/${purchase.id}`" class="btn btn-custom btn-sm btn-primary">View</router-link>
	       					<router-link :to="`/admin/purchases/edit/${purchase.id}`" class="btn btn-custom btn-sm btn-secondary">Edit</router-link>
	       					<router-link :to="`/admin/purchases/delete/${purchase.id}`" class="btn btn-custom btn-sm btn-danger">Delete</router-link>
	       				</td>
	       			</tr>
	       		</template>	
	       	</tbody>
       </table>
       <pagination :data="postData" :limit="5" @pagination-change-page="getResults"></pagination>
	</div>
</template>

<script>
	export default {
		name: 'list',
		data() {
			return {
				postData: {}, 
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		mounted() {
			this.getResults();
		},
		methods: {
			getResults(page = 1) {
				axios.get('/api/approve-purchases?page=' + page, {
					 headers: {
				  	 "Authorization" : `Bearer ${this.currentUser.token}`
				  }
				})
					.then(response => {
						this.postData = response.data.purchases;
					});
			}
		}
	}
</script>