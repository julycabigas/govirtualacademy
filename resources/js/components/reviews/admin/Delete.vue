<template>
	<div class="course-delete">
		<form @submit.prevent="update">
			<table class="table">
				<tr>
					<th>Testimony</th>
				</tr>
				<tr>
					<td>
						<div v-html="review.content"></div>
					</td>
				</tr>
				<tr>
						<input type="submit" value="Delete" class="btn btn-primary" />
						<router-link to="/courses" class="btn">Cancel</router-link>
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
				review: {
					content: ''
				},
				errors: null,
			}
		},
		created() {

			axios.get(`/api/reviews/${this.$route.params.id}`)
				 .then((response) => {

				 	 this.review = response.data.review;
				 })
				 .catch((error) => {
				 	console.log(error);
				 })
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			reviews() {
				return this.$store.getters.reviews;
			}
		},
		methods: {
			update() {

				axios.post(`/api/reviews/delete/${this.$route.params.id}`,  {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
					this.$router.push('/admin/reviews');
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