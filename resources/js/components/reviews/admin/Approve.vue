<template>
	<div>
		<form @submit.prevent="approve">
			<h5>Quote</h5>
			<blockquote v-html="review.content"></blockquote>
			<div><span>Created by {{ review.user_id }}</span></div><br><br>
			<input type="submit" class="btn btn-primary" value="Approve">
		</form>
	</div>
</template>
<script>
	export default {
		name: 'approval',
		data() {
			return {
				review: {
					user_id: '',
					content: ''
				}
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
			}
		},
		methods: {
			approve() {

				axios.post(`/api/reviews/approve/${this.$route.params.id}`, {
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