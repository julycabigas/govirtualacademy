<template>
	<div class="container">
		 <table class="table table-striped">
		 	<thead>
		 	  <tr>
		 	  	<th>Student</th>
		 	  	<th width="400">Content</th>
		 	  	<th>Status</th>
		 	  	<th>Date</th>
		 	  	<th>Action</th>
		 	  </tr>
		 	</thead>
		 	<tbody>
		 	  <tr v-for="review in reviews.data" :key="review.id">
	
		 	  	<td v-if="review.user.image">
		 	  		<img :src="`/users/${review.user.image}`" width="64" alt="User Image">
		 	  	</td>
		 	  	<td v-else>
		 	  		<img :src="`/images/${review['image']}`" width="64" alt="Review Thumbnail">
		 	  	</td>
		 	  	<td><div v-html="review.content"></div></td>
		 	  	<td>{{ review.approve ? 'Approve': '' }}</td>
		 	  	<td>{{ review.created_at }}</td>
		 	  	<td>
		 	  		<router-link :to="`/admin/students/${review.user_id}`"  class="btn btn-custom btn-sm btn-primary">User</router-link> 
		 	  		<router-link :to="`/admin/reviews/edit/${review.id}`"  class="btn btn-custom btn-sm btn-primary">Edit</router-link> 
		 	  		<template v-if="!review.approve">
		 	  			<router-link :to="`/admin/reviews/approve/${review.id}`"  class="btn btn-custom btn-sm btn-success">Approve</router-link>
		 	  		</template>
		 	  		
		 	  		<router-link :to="`/admin/reviews/delete/${review.id}`"  class="btn btn-custom btn-sm btn-danger">Delete</router-link>
		 	  	</td>
		 	  </tr>
		 	</tbody>
		 </table>
		 <pagination :data="reviews" :limit="5" @pagination-change-page="getResults"></pagination>
	</div>
</template>
<script>
	export default {
		name: 'list',
		data() {
			return {
				reviews: {}
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		mounted() {
			if(this.reviews.length) {
				return;
			}
			this.$store.dispatch('getReviews');
			this.getResults();
		},
		methods: {
			getUser(id) {
				let image = '';
				axios.get(`/api/reviews/${id}`)
				 .then((response) => {

				 	this.image = response.data.review.image;
				 })
				 .catch((error) => {
				 	console.log(error);
				 })

				 return this.image;
			},
			getResults(page = 1) {
				axios.get('/api/reviews?page=' + page,  {
						headers: {
							"Authorization": `Bearer ${this.currentUser.token}`
						}
					})
					.then(response => {
						this.reviews = response.data.reviews;
					});
			}

		}
	}
</script>
<style scoped>
  img {
  	 border-radius: 50%;
  }
	
</style>