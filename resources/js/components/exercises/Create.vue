<template>
	<div class="video-new">
		
		<form @submit.prevent="add">
			<table class="table">
				<tr>
					<th>Title</th>
					<td>
						<input type="text" v-model="exercise.title">
					</td>
				</tr>
				<tr>
					<th>Description</th>
					<td>
						<VueEditor type="text" v-model="exercise.description"></VueEditor>
					</td>
				</tr>
				<tr>
					<th>Group ID</th>
					<td>
						<select v-model="exercise.group_identifiers_id">
                            <option value="">Select Course</option>
						    <option v-for="course in course_identifiers" :key="course.id" :value="course.id"> {{ course.name }} - {{ course.title }}</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<router-link to="/courses" class="btn btn-cancel">Cancel</router-link>
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
				exercise: {
					title: '',
					description: '',
					group_id: '' 
				},
				errors: null,
				course_identifiers: {},
				groupID: ''
			}
		},
		mounted() {
           
		},
		created() { 
			this.getAllCourseGroup();
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
				const errors 	  = validate(this.$data.exercise, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}


				//Add new exercise
				axios.post('/api/exercises/create', { 
                    'exercise' : this.$data.exercise,
       
				   }, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
					console.log(response.data);
                    //if successful go the list
                    if(response.data.exercise.id) {
                        this.$router.push('/admin/exercises');
                    }
				})
			},
			getAllCourseGroup() {
				axios.get(`/api/task-group-identifiers`, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
					.then((response) => {
				
						this.course_identifiers  = response.data.groups;
					})
					.catch((error) => {
					  	  console.log(error);
					});
			},
			getConstraints() {
				return {
					title: {
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