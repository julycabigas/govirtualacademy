<template>
	<div class="video-new">
		
		<form @submit.prevent="add">
			<table class="table">
				<tr>
					<th>Name</th>
					<td>
						<input type="text" v-model="resource.name">
					</td>
				</tr>
				<tr>
					<th>Description</th>
					<td>
						<vue-editor v-model="resource.description"></vue-editor>
					</td>
				</tr>
				<tr>
					<th>Category</th>
					<td>
						<select v-model="resource.category_id">
                            <option value="">Select Category</option>
						    <option v-for="cat in categories" :key="cat.id" :value="cat.id"> {{ cat.name }} </option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<router-link to="/admin/resources" class="btn btn-cancel">Cancel</router-link>
					</td>
					<td>
						<input type="submit" value="Submit" class="btn btn-primary" />
					</td>
				</tr>
			</table>
		</form>
		<div class="errors" v-if="errors">
			<ul>
				<li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
					<strong>{{ fieldName }}</strong> {{ fieldsError.join('\n') }}
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
	import validate from 'validate.js';
	import { VueEditor } from 'vue2-editor';

	export default {
		name: 'create',
		components: {
			VueEditor
		},
		data() {
			return {
				resource: {
					name: '',
					description: ''
				},
				errors: null,
				categories: {},
				groupID: ''
			}
		},
		created() { 
			axios.get(`/api/resources/${this.$route.params.id}`)
				 .then((response) => {
					  this.resource = response.data.resource;
				 })
				 .catch((error) => {
				 	console.log(error);
				 });
			this.getCategories();	 
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
		},
		methods: {
			getCategories() {
				axios.get(`/api/resource-category-list`, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
					.then((response) => {
						console.log(response.data);
						this.categories  = response.data.resource;
					})
					.catch((error) => {
					  	  console.log(error);
					});
			},
			add() {
				this.errors = null;
				const constraints = this.getConstraints();
				const errors 	  = validate(this.$data.resource, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}


				//Add new course
				axios.post(`/api/resources/update/${this.$route.params.id}`, {
						'resource' : this.$data.resource,
				   }, 
				   {
					headers: { "Authorization": `Bearer ${this.currentUser.token}` }
					})
					.then((response) => {
					
						//if success go the list
						if(response.data.resource.id) {
							this.$router.push('/admin/resources');
						}
					})
			},
			getConstraints() {
				return {
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
							minimum: 10,
							message: 'Must be at least 5 characters long'
						}
					},

					
				}
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
    .btn.btn-cancel {
        border: 1px solid #222f3f;
    }
</style>