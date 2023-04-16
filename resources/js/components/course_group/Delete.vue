<template>
	<div class="course-delete">
		<form @submit.prevent="update">
			<table class="table">
				<tr>
					<th>Please click 'Delete' to delete the course</th>
					<td>
						{{ course.name }}
					</td>
				</tr>
				<tr>
					<td>
						<router-link to="/courses" class="btn btn-secondary btn-outline">Cancel</router-link>
					</td>
					<td>
						<input type="submit" value="Delete" class="btn btn-primary" />
					</td>
				</tr>
			</table>
		</form>
		
	</div>
</template>

<script>
	export default {
		name: 'delete',
		data() {
			return {
				course: {
					name: ''
				},
				errors: null,
			}
		},
		created() {

			axios.get(`/api/course-identifiers-group/${this.$route.params.id}`)
				 .then((response) => {
					  this.course = response.data.course;
					  console.log(response.data);
				 })
				 .catch((error) => {
				 	console.log(error);
				 })
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			courses() {
				return this.$store.getters.courses;
			}
		},
		methods: {
			update() {

				axios.post(`/api/course-identifiers/delete/${this.$route.params.id}`,  {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
					this.$router.push('/admin/courses-group');
				})
			}
			
		}
	}
</script>

<style scoped>
	.errors ul {
	    list-style: none;
	    padding: 0;
	    margin: 0;
	}
	.errors li {
	    background: #f3dcdc;
	    border-radius: 4px;
	    padding: 5px 10px;
	    margin-bottom: 5px;
	}
</style>