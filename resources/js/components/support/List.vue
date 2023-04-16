<template>
	<div>
       <table class="table table-striped">
	       	<thead>
				<th>ID</th>
	       		<th>Name</th>
				<th>Description</th>
	       		<th>Action</th>
	       	</thead>
	       	<tbody>
	       		<template v-if="!badges">
	       			<tr>
	       				<td colspan="4" class="text-center">No badges available</td>
	       			</tr>
	       		</template>
	       		<template v-else>
	       			<tr v-for="badge in badges.data" :key="badge.id">
						<td>{{ badge.id }}</td>
	       				<td>{{ badge.badges.name }}</td>
						<td>{{ badge.badges.description }}</td>
	       				<td width="150">
	       					<router-link :to="`/admin/badges/edit/${badge.id}`" class="btn btn-custom btn-sm btn-secondary">Edit</router-link>
	       					<router-link :to="`/admin/badges/delete/${badge.id}`" class="btn btn-custom btn-sm btn-danger">Delete</router-link>
	       				</td>
	       			</tr>
	       		</template>	
	       	</tbody>
       </table>
       <pagination :data="badges" :limit="5" @pagination-change-page="getResults"></pagination>
	</div>
</template>

<script>
	export default {
		name: 'list',
		data() {
			return {
				badges: {}
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
				axios.get('/api/student-badges?page=' + page, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
					.then(response => {
						this.badges = response.data.badges;
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