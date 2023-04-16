<template>
	<div class="course-delete">
		<form @submit.prevent="update">
			<table class="table">
				<tr>
					<th>Please click 'Delete' to delete the exercise</th>
					<td>
						{{ exercise.title }}
					</td>
				</tr>
				<tr>
					<td>
						<router-link to="/admin/exercises" class="btn btn-secondary btn-outline">Cancel</router-link>
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
				exercise: {
					title: ''
				},
				errors: null,
			}
		},
		created() {

			axios.get(`/api/exercises/${this.$route.params.id}`)
				 .then((response) => {
					  this.exercise = response.data.exercise;
					
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

				axios.post(`/api/exercises/delete/${this.$route.params.id}`,  {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
					this.$router.push('/admin/exercises');
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