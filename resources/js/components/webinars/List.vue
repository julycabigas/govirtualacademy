<template>
	<div>
       <table class="table table-striped">
	       	<thead>
				<th>ID</th>
	       		<th>Name</th>
				<th>Host</th>
	       		<th>Action</th>
	       	</thead>
	       	<tbody>
	       		<template v-if="!webinars">
	       			<tr>
	       				<td colspan="4" class="text-center">No webinars available</td>
	       			</tr>
	       		</template>
	       		<template v-else>
	       			<tr v-for="webinar in webinars.data" :key="webinar.id">
						<td>{{ webinar.id }}</td>
	       				<td>{{ webinar.name }}</td>
						<td>{{ webinar.host }}</td>
	       				<td width="150">
	       					<router-link :to="`/admin/webinars/edit/${webinar.id}`" class="btn btn-custom btn-sm btn-secondary">Edit</router-link>
	       					<router-link :to="`/admin/webinars/delete/${webinar.id}`" class="btn btn-custom btn-sm btn-danger">Delete</router-link>
	       				</td>
	       			</tr>
	       		</template>	
	       	</tbody>
       </table>
       <pagination :data="webinars" :limit="5" @pagination-change-page="getResults"></pagination>
	</div>
</template>

<script>
	export default {
		name: 'list',
		data() {
			return {
				webinars: {}
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
				axios.get('/api/webinars?page=' + page, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then(response => {
					this.webinars = response.data.webinars;
				});
			}
		}
	}
</script>
<style scoped>
.btn-success {
    border-color: #8fe093;
    background-color: #8fe093;
}
.btn-info {
    border-color: #5eb2e6;
    background-color: #5eb2e6;
    color: #fff;
}
</style>