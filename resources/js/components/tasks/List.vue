<template>
	<div>
		<form class="form-search form-inline mb-3 text-right align-right" @submit.prevent="getResults">
			<input type="text" class="form-control mr-2" v-model="inputSearch" placeholder="search"/>
			<input type="submit"  class="form-control btn btn-primary" value="Search" />
		</form>

       <table class="table table-striped">
	       	<thead>
				<th>ID</th>
	       		<th>Name</th>
				<th>Description</th>
	       		<th>Action</th>
	       	</thead>
	       	<tbody>
	       		<template v-if="!tasks">
	       			<tr>
	       				<td colspan="4" class="text-center">No courses available</td>
	       			</tr>
	       		</template>
	       		<template v-else>
	       			<tr v-for="task in tasks.data" :key="task.id">
						<td>{{ task.id }}</td>
	       				<td>{{ task.name }}</td>
						<td>{{ task.description}}</td>
	       				<td width="150">
	       					<router-link :to="`/admin/tasks/edit/${task.id}`" class="btn btn-custom btn-sm btn-secondary">Edit</router-link>
	       					<router-link :to="`/admin/tasks/delete/${task.id}`" class="btn btn-custom btn-sm btn-danger">Delete</router-link>
	       				</td>
	       			</tr>
	       		</template>	
	       	</tbody>
       </table>
       <pagination :data="tasks" :limit="5" @pagination-change-page="getResults"></pagination>
	</div>
</template>

<script>
	export default {
		name: 'list',
		data() {
			return {
				tasks: {},
				inputSearch: ''
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
			getResults( page = 1) {
				console.log('results');
				let keyword = this.inputSearch;
				if(keyword) {
					axios.get('/api/tasks?page=' + page + '&keyword= ' + keyword, {
						headers: {
							"Authorization": `Bearer ${this.currentUser.token}`
						}
					})
					.then(response => {
						console.log(response.data);
						this.tasks = response.data.tasks;
					});
				} else {
					axios.get('/api/tasks?page=' + page, {
						headers: {
							"Authorization": `Bearer ${this.currentUser.token}`
						}
					})
					.then(response => {
						console.log(response.data);
						this.tasks = response.data.tasks;
					});
			
				}
			},
			search() {
				console.log('test....' + this.inputSearch);
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