<template>
	<div class="container">
		<form @submit.prevent="update">

			<div class="form-group">
				<label for="name">Category Name</label>
				<input id="name" type="text" v-model="category.name" class="form-control">
			</div>

			<div class="form-group">
				<label for="description">Category Description</label>
				<input id="description" type="text" v-model="category.description" class="form-control">
			</div>

			<input type="submit" value="Submit" class="btn btn-primary">

			<div class="errors" v-if="errors">
				<ul>
					<li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
						<strong>{{ fieldName }}</strong> {{ fieldsError.join('\n') }}
					</li>
				</ul>
			</div>
		</form>
	</div>
</template>
<script>
	import validate from 'validate.js';
	export default {
		name: 'edit',
		data() {
			return {
				category: {
					name: '',
					description: ''
				},
				errors: null
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		mounted() {
			this.getCategory();
		},
		methods: {
			getCategory() {
				axios.get(`/api/categories/${this.$route.params.id}`)
					 .then((response) => {
					 	console.log(response.data.category);
					 	this.category = response.data.category;
					 })
			},
			update() {

				this.errors = null;

				const constraints = this.getConstraints();

				const errors = validate(this.$data.category, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}
				axios.post(`/api/categories/update/${this.$route.params.id}`, this.$data.category, {
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					.then((response) => {
						 this.$router.go();
						 //this.$router.push({ name: 'list', params: { message: 'Successfully added new category' } })
					})
					.catch((error) => {
						console.log(error);
					});


			},
			getConstraints() 
			{
				return  {
					name: {
						presence: true, 
						length: {
							minimum: 5,
							message: 'Must be at least 5 characters long'
						}
					},
					description: {
                        presence: true, 
						length: {
							minimum: 5,
							message: 'Must be at least 5 characters long'
						}
					}
				}
			}
		}
	}
</script>