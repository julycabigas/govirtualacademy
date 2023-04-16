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
	       		<template v-if="!courses">
	       			<tr>
	       				<td colspan="4" class="text-center">No courses available</td>
	       			</tr>
	       		</template>
	       		<template v-else>
	       			<tr v-for="course in courses.data" :key="course.id">
						<td>{{ course.id }}</td>
	       				<td>{{ course.name }}</td>
						<td>{{ course.description}}</td>
	       				<td width="150">
	       					<router-link :to="`/admin/courses-group/edit/${course.id}`" class="btn btn-custom btn-sm btn-secondary">Edit</router-link>
	       					<router-link :to="`/admin/courses-group/delete/${course.id}`" class="btn btn-custom btn-sm btn-danger">Delete</router-link>
	       				</td>
	       			</tr>
	       		</template>	
	       	</tbody>
       </table>
       <pagination :data="courses" :limit="5" @pagination-change-page="getResults"></pagination>
	</div>
</template>

<script>
	export default {
		name: 'list',
		data() {
			return {
				courses: {}
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
				axios.get('/api/course-identifiers?page=' + page, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
					.then(response => {
						console.log(response.data);
						this.courses = response.data.courses_identifiers;
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