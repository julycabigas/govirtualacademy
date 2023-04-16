<template>
	<div class="container">
		<form @submit.prevent="add">

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
		name: 'new',
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
		methods: {
			add() {

				this.errors = null;

				const constraints = this.getConstraints();

				const errors = validate(this.$data.category, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}
				axios.post('/api/categories/new', this.$data.category, {
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					.then((response) => {
						 this.$router.push('/admin/categories');
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