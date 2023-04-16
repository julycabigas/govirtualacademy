<template>
	<div>
       <table class="table table-striped">
	       	<thead>
	       		<th>Course Title</th>
	       		<th>Total Lessons</th>
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
	       				<td>{{ course.title }}</td>
	       				<td class="text-center">{{ course.video.length }}</td>
	       				<td width="350">
	       					<router-link :to="`/admin/courses/${course.id}`" class="btn btn-custom btn-sm btn-primary">View</router-link>
	       					<router-link :to="`/admin/courses/edit/${course.id}`" class="btn btn-custom btn-sm btn-secondary">Edit</router-link>
	       					<router-link :to="`/admin/courses/lesson/${course.id}`" class="btn btn-custom btn-sm btn-success">Lessons</router-link>
	       					<router-link :to="`/admin/examination/list/${course.id}`" class="btn btn-custom btn-sm btn-info">Exams</router-link>
	       					<router-link :to="`/admin/courses/delete/${course.id}`" class="btn btn-custom btn-sm btn-danger">Delete</router-link>
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
			if (this.courses.length) {
                return;
            }
			this.$store.dispatch('getCourses');
			this.getResults();
		},
		methods: {
			getResults(page = 1) {
				axios.get('/api/courses?page=' + page, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
					.then(response => {
				
						this.courses = response.data.courses;
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