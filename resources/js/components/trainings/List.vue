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
	       				<td colspan="4" class="text-center">No courses available</td>
	       			</tr>
	       		</template>
	       		<template v-else>
	       			<tr v-for="purchase in postData.data" :key="purchase.id">
	       				<td>{{ purchase.created_at }}</td>
	       				<td>{{ purchase.user.firstname }} {{ purchase.user.lastname }}</td>
	       				<td>{{ purchase.amount }}</td>
	       				<td width="200">{{ purchase.payment_method }}</td>
	       				<td width="150">
	       					<router-link :to="`/admin/purchase/${purchase.id}`" class="btn btn-custom btn-sm btn-primary">View</router-link>
	       					<router-link :to="`/admin/purchase/${purchase.id}`" class="btn btn-custom btn-sm btn-secondary">Edit</router-link>
	       				</td>
	       			</tr>
	       		</template>	
	       	</tbody>
       </table>
       <pagination :data="postData" @pagination-change-page="getResults"></pagination>
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
		mounted() {
			this.getResults();
		},
		methods: {
			getResults(page = 1) {
				axios.get('/api/purchases?page=' + page)
					.then(response => {
						this.postData = response.data.purchases;
					});
			}
		}
	}
</script>