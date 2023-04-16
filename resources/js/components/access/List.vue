<template>
	<div class="container">
		 <table class="table table-striped">
		 	<thead>
		 	  <tr>
		 	  	<th>Training</th>
		 	  	<th>Regular Price</th>
		 	  	<th>Discounted Price</th>
		 	  	<th>Type</th>
		 	  	<th>Action</th>
		 	  </tr>
		 	</thead>
		 	<tbody>  

		 	  <tr v-for="access in postData.data" :key="access.id">
		 	  	<td>{{ access.display_name }}</td>
		 	  	<td>{{ access.reg_price }}</td>
		 	  	<td><strong>{{ access.discount_price }}</strong></td>
		 	  	<td>{{ access.type }}</td>
		 	  	<td width="100">
		 	  		<router-link :to="`/admin/training/edit/${access.id}`" class="btn btn-custom btn-sm btn-primary">Edit</router-link>
		 	  	</td>
		 	  </tr>
		 	</tbody>  
		 </table>
		 <pagination :data="postData" @pagination-change-page="getResults"></pagination>

	</div>
</template>
<script>
	export default {
		name: 'list-access',
		data() {
			return {
				postData: {}, 
			}
		},
		mounted() {

			this.getResults();
		},
		methods: {
			
			getResults(page = 1) {
				axios.get('/api/access?page=' + page, {
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					.then(response => {
						console.log(response.data);
						this.postData = response.data.access_levels;
					});
			}
			
		},
		computed: {
			access_levels() {
				return this.$store.getters.access_levels;
			},
			currentUser() {
				return this.$store.getters.currentUser;
			}
		}
	}
</script>