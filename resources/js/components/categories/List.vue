<template>
	<div class="container">
		 <table class="table table-striped">
		 	<thead>
		 	  <tr>
		 	  	<th>Name</th>
		 	  	<th>Description</th>
		 	  	<th>Action</th>
		 	  </tr>
		 	</thead>
		 	<tbody>
		 	  <tr v-for="category in categories" :key="category.id">
		 	  	<td>{{ category.name}}</td>
		 	  	<td>{{ category.description }}</td>
		 	  	<td width="100"><router-link :to="`/admin/categories/${category.id}`"  class="btn btn-custom btn-sm btn-success">Edit</router-link></td>
		 	  </tr>
		 	</tbody>
		 </table>
	</div>
</template>
<script>
	export default {
		name: 'category-list',
		data() {
			return {
				categories: {
					name: '',
					description: ''
				},
				errors: null
			}
		},
		computed: {
			categories() 
			{
				return this.$store.getters.categories;
			}
		},
		mounted() {

			this.getCategory();

		},
		methods: {
			getCategory() {
				axios.get(`/api/categories`)
					 .then((response) => {
					 	console.log(response.data.categories);
					 	this.categories = response.data.categories;
					 })
			}
		}

	}
</script>