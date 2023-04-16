<template>
	<div>
       <table class="table table-striped">
	       	<thead>
				<th>ID</th>
	       		<th>Name</th>
	       		<th>Action</th>
	       	</thead>
	       	<tbody>
	       		<template v-if="!resources">
	       			<tr>
	       				<td colspan="4" class="text-center">No resources available</td>
	       			</tr>
	       		</template>
	       		<template v-else>
	       			<tr v-for="resource in resources.data" :key="resource.id">
						<td>{{ resource.id }}</td>
	       				<td>{{ resource.name }}</td>
	       				<td width="150">
	       					<router-link :to="`/admin/resources/cat-delete/${resource.id}`" class="btn btn-custom btn-sm btn-danger">Delete</router-link>
	       				</td>
	       			</tr>
	       		</template>	
	       	</tbody>
       </table>
       <pagination :data="resources" :limit="5" @pagination-change-page="getResults"></pagination>
	</div>
</template>

<script>
	export default {
		name: 'list',
		data() {
			return {
				resources: {}
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
				axios.get('/api/resource-category?page=' + page, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
					.then(response => {
						this.resources = response.data.resources;
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