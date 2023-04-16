<template>
	<div class="course-delete">
		<form @submit.prevent="update">
			<table class="table">
				<tr>
					<th>Please click 'Delete' to delete the task</th>
					<td>
						Delete <strong>{{ task.tasks.name }}</strong> from completed tasks of {{ task.users.firstname }} {{ task.users.lastname }}
					</td>
				</tr>
				<tr>
					<td>
						<router-link to="/admin/tasks/student-list" class="btn btn-secondary btn-outline">Cancel</router-link>
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
				task: {

                    tasks: {
                        name: ''
                    },
                    users: {
                        firstname: '',
                        lastname: ''
                    }
				},
				errors: null,
			}
		},
		created() {

			axios.get(`/api/task-entry/${this.$route.params.id}`)
				 .then((response) => {
                     console.log(response.data);
					  this.task = response.data.task;
					
				 })
				 .catch((error) => {
				 	console.log(error);
				 })
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		methods: {
			update() {

				axios.post(`/api/task-entry/delete/${this.$route.params.id}`,  {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
					this.$router.push('/admin/tasks/student-list');
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