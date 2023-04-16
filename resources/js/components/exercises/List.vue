<template>
	<div>
		<form class="form-search form-inline mb-3 text-right align-right" @submit.prevent="getResults">
			<input type="text" class="form-control mr-2" v-model="inputSearch" placeholder="search"/>
			<input type="submit"  class="form-control btn btn-primary" value="Search" />
		</form>

       <table class="table table-striped">
	       	<thead>
				<th>ID</th>
	       		<th>Title</th>
				<th>Description</th>
	       		<th>Action</th>
	       	</thead>
	       	<tbody>
	       		<template v-if="!exercises">
	       			<tr>
	       				<td colspan="4" class="text-center">No exercises available</td>
	       			</tr>
	       		</template>
	       		<template v-else>
	       			<tr v-for="exercise in exercises.data" :key="exercise.id">
						<td>{{ exercise.id }}</td>
	       				<td>{{ exercise.title }}</td>
						<td><div v-html="exercise.description"></div></td>
	       				<td width="200">
	       					<router-link :to="`/admin/exercises/edit/${exercise.id}`" class="btn btn-custom btn-sm btn-secondary">Edit</router-link>
	       					<router-link :to="`/admin/exercises/delete/${exercise.id}`" class="btn btn-custom btn-sm btn-danger">Delete</router-link>
	       				</td>
	       			</tr>
	       		</template>	
	       	</tbody>
       </table>
       <pagination :data="exercises" :limit="5" @pagination-change-page="getResults"></pagination>
	</div>
</template>

<script>
	export default {
		name: 'list',
		data() {
			return {
				exercises: {},
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

				let keyword = this.inputSearch;
				if(keyword) {
					axios.get('/api/exercises?page=' + page + '&keyword= ' + keyword, {
						headers: {
							"Authorization": `Bearer ${this.currentUser.token}`
						}
					})
					.then(response => {
						this.exercises = response.data.exercises;
					});
				} else {
					axios.get('/api/exercises?page=' + page, {
						headers: {
							"Authorization": `Bearer ${this.currentUser.token}`
						}
					})
					.then(response => {
						this.exercises = response.data.exercises;
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