<template>
	<div class="video-new">
		
		<form @submit.prevent="add">
			<table class="table">
				<tr>
					<th>Name</th>
					<td>
						<input type="text" v-model="badge.name">
					</td>
				</tr>
				<tr>
					<th>Description</th>
					<td>
						<textarea type="text" v-model="badge.description"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<router-link to="/badges" class="btn btn-cancel">Cancel</router-link>
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
				badge: {
					name: '',
					description: ''
				},
				errors: null,
				course_identifiers: {},
				groupID: ''
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
				const errors 	  = validate(this.$data.badge, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}


				//Add new badge
				axios.post('/api/badges/create', { 
                    'badge' : this.$data.badge,
       
				   }, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {

                    //if successful go the list
                    if(response.data.badge.id) {
                        this.$router.push('/admin/badges');
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
							minimum: 5,
							message: 'Must be at least 10 characters long'
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