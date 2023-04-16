<template>
	<div class="video-new">
		<div class="alert alert-success" v-if="$route.query.status == 'updated'">
			Category has been successfully added!
			 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			 </button>
		</div>
		<form @submit.prevent="add">
			<table class="table">
				<tr>
					<th>Name</th>
					<td>
						<input type="text" v-model="resource_category.name">
					</td>
				</tr>
				<tr>
					<td>
					
					</td>
					<td>
						<input type="submit" value="Submit" class="btn btn-primary" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</template>

<script>
	import validate from 'validate.js';
	import { VueEditor } from 'vue2-editor';

	export default {
		name: 'new',
		components: {
			VueEditor
		},
		data() {
			return {
				resource_category: {},
				error: ''
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			roles() {
				return this.$store.getters.roles;
			}
		},
		methods: {
			add() {

				//Add new course
				axios.post('/api/resource-category/create', { 
					'resource' : this.$data.resource_category,

				   }, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
                
                     this.$router.push('/admin/resources');
                    
				})
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
</style>