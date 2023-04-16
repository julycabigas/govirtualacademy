<template>
	<div class="video-new">
		
		<form @submit.prevent="add">
			<table class="table">
				<tr>
					<th>Name</th>
					<td>
						<input type="text" v-model="task.name">
					</td>
				</tr>
				<tr>
					<th>Description</th>
					<td>
						<VueEditor v-model="task.description"></VueEditor>
					</td>
				</tr>
				<tr>
					<th>Notes</th>
					<td>
						<VueEditor v-model="task.notes"></VueEditor>
					</td>
				</tr>
				<tr>
					<th>Which step is this? </th>
					<td> 
						<select v-model="task.group_identifiers_id">
                            <option value="">Select Course</option>
						    <option v-for="course in course_identifiers"  :key="course.id" :value="course.id">{{ course.name }} - {{ course.title }}</option>
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
				task: {
					name: '',
					description: '',
					group_identifiers_id: '',
					notes: '' 
				},
				errors: null,
				course_identifiers: {},
				groupID: ''
			}
		},
		mounted() {
			this.getAllCourseGroup();
		},
		created() { 
			axios.get(`/api/tasks/${this.$route.params.id}`)
				 .then((response) => {
					  this.task = response.data.task;
				 })
				 .catch((error) => {
				 	console.log(error);
				 });
				 
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
		},
		methods: {
			add() {
				this.errors = null;
				const constraints = this.getConstraints();
				const errors 	  = validate(this.$data.task, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}


				//Add new course
				axios.post(`/api/tasks/update/${this.$route.params.id}`, {
						'task' : this.$data.task,

				   }, 
				   {
					headers: { "Authorization": `Bearer ${this.currentUser.token}` }
					})
					.then((response) => {
					
						//if success go the list
						if(response.data.task.id) {
							this.$router.push('/admin/tasks');
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