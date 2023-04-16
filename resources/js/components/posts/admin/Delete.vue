<template>
	<div class="delete-area">
		<h2>Deleting</h2>
		<form @submit.prevent="update">
			
           <div class="form-group">
           	  <label for="title">Title</label>
           	  <input id="name" type="text" v-model="post.title" class="form-control" readonly>
           </div>

           <input type="submit" value="Delete" class="btn btn-primary">
		</form>
	</div>
</template>
<script>
	export default {
		name: 'delete',
		data() {
			return {
				post: {
					title: '',
					content: '',
					status: ''
				},
				errors: null
			}
		},
		mounted() {
			this.getPost();
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		methods: {
			getPost() {
				axios.get(`/api/posts/${this.$route.params.id}`)
					 .then((response) => {
					 	this.post = response.data.post;
					 })
			},
			update() {

				axios.post(`/api/posts/delete/${this.$route.params.id}`, {
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					.then((response) => {
						console.log(response.data.message);
						this.$router.push('/admin/posts');
					})
					.catch((error) => {
						console.log(error);
					});
			}

		}
	}
</script>