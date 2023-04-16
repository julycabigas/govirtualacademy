<template>
	<div>
       <table class="table table-striped">
	       	<thead>
				<th>ID</th>
	       		<th>Training</th>
				<th>Course</th>
				<th>Menu Order</th>
	       		<th>Action</th>
	       	</thead>
	       	<tbody>
	       		<template v-if="!groups">
	       			<tr>
	       				<td colspan="4" class="text-center">No groups available</td>
	       			</tr>
	       		</template>
	       		<template v-else>
	       			<tr v-for="group in groups.data" :key="group.id">
						<td>{{ group.id }}</td>
	       				<td>{{ group.identifier.name }}</td>
						<td>{{ group.course.title }}</td>
						<td>{{ group.menu_order }}</td>
	       				<td width="150">
	       					<router-link :to="`/admin/all-groups/edit/${group.id}`" class="btn btn-custom btn-sm btn-secondary">Edit</router-link>
	       					<router-link :to="`/admin/all-groups/delete/${group.id}`" class="btn btn-custom btn-sm btn-danger">Delete</router-link>
	       				</td>
	       			</tr>
	       		</template>	
	       	</tbody>
       </table>
       <pagination :data="groups" :limit="5" @pagination-change-page="getResults"></pagination>
	</div>
</template>

<script>
	export default {
		name: 'list-group',
		data() {
			return {
				groups: {}
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
				axios.get('/api/group-courses?page=' + page, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
					.then(response => {
						console.log(response.data);
						this.groups = response.data.groups;
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