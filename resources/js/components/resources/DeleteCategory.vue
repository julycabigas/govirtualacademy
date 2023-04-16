<template>
	<div class="course-delete">
		<form @submit.prevent="update">
			<table class="table">
				<tr>
					<th>Please click 'Delete' to delete the resource</th>
					<td>
						resource ID: {{ resource.id }}
					</td>
				</tr>
				<tr>
					<td>
						<router-link to="/resources" class="btn btn-secondary btn-outline">Cancel</router-link>
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
				resource: {
					name: ''
				},
				errors: null,
			}
		},
		created() {

			axios.get(`/api/resource-category/${this.$route.params.id}`)
				 .then((response) => {
					  this.resource = response.data.resource;
					
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

				axios.post(`/api/resource-category/delete/${this.$route.params.id}`,  {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
					this.$router.push('/admin/resources/cat-list');
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