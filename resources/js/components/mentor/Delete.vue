<template>
	<div class="video-new">
		<form @submit.prevent="update">
			<table class="table">
				<tr>
					<th>Delete this student!</th>
					<td>
						{{ student.firstname }} {{ student.lastname }}


					</td>
				</tr>
				<tr>
					<td>
						<router-link to="/admin/students" class="btn btn-success">Cancel</router-link>
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
				student: {
					firstname: '',
					title: '',
					description: '',
					file: '',
					course_id: ''
				},
				errors: null,
			}
		},
		created() {

			axios.get(`/api/students/${this.$route.params.id}`)
				 .then((response) => {
				 	console.log(response.data.student);
				 	 this.student = response.data.student;
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
				axios.post(`/api/students/delete/${this.$route.params.id}`,  {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
					this.$router.push({ path: '/admin/mentors', query: { status: 'Deleted' } });
				})
			}
			
		}
	}
</script>

<style>
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