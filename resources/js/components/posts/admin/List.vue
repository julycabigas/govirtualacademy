<template>
	<div class="container">
		 <table class="table table-striped">
		 	<thead>
		 	  <tr>
		 	  	<th>Title</th>
		 	  	<th>Status</th>
		 	  	<th>Action</th>
		 	  </tr>
		 	</thead>
		 	<tbody>  

		 	  <tr v-for="post in postData.data" :key="post.id">
		 	  	<td>{{ post.title}}</td>
		 	  	<td>{{ post.status }}</td>
		 	  	<td width="230">
		 	  		<router-link :to="`/admin/posts/${post.id}`" class="btn btn-custom btn-sm btn-primary">View</router-link> 
		 	  		<router-link :to="`/admin/posts/edit/${post.id}`" class="btn btn-custom btn-sm btn-success">Edit</router-link>
		 	  		<router-link :to="`/admin/posts/delete/${post.id}`" class="btn btn-custom btn-sm btn-danger">Delete</router-link>
		 	  	</td>
		 	  </tr>
		 	</tbody>  
		 </table>
		 <pagination :data="postData" @pagination-change-page="getResults"></pagination>
	</div>
</template>
<script>
	export default {
		name: 'list',
		data() {
			return {
				postData: {}, 
			}
		},
		mounted() {
			if(this.postData.length) {
				return;
			}
			this.$store.dispatch('getPosts');
			this.getResults();
		},
		methods: {
			getResults(page = 1) {
				axios.get('/api/posts?page=' + page)
					.then(response => {
						this.postData = response.data.posts;
					});
			}
		}
	}
</script>