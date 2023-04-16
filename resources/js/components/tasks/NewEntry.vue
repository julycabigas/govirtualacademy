<template>
	<div class="video-new">
		<div class="alert alert-success" v-if="$route.query.status == 'updated'">
			A task has been successfully added to a student!
			 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			 </button>
		</div>
		<form @submit.prevent="add">
			<table class="table">
                <tr>
					<th>Tasks</th>
					<td>
						<select v-model="taskID">
                            <option value="">Select a task</option>
						    <option  v-for="task in tasks" :key="task.id" :value="task.id">{{ task.name }}</option>
						</select>
					</td>
				</tr>
				<tr>
					<th width="200">Students</th>
					<td>
						<select v-model="studentID">
                            <option value="">Select a student</option>
						    <option v-for="student in students" :key="student.id" :value="student.id">{{ student.firstname }} {{ student.lastname }} - {{ student.email }}</option>
						</select>
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
				students: {},
				tasks: {},
				studentID: '',
				taskID: ''
			}
		},
		created() {

				axios.get(`/api/tasklist`)
					 .then((response) => { 
					    this.tasks = response.data.tasks;     
                     });

                axios.get(`/api/students-list`)
					 .then((response) => { 
					    this.students = response.data.students;     
                     })
                
                
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
				axios.post('/api/student-tasks/new', { 
                    'taskID' : this.$data.taskID,
					'studentID' : this.$data.studentID,
				   }, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
                
                    console.log(response.data);
                    
                    if(response.data.status) {
                        this.$router.push({ path: `/admin/tasks/new/`, query: { status: 'updated' } });
						this.studentID = '';
						this.badgeID = '';
                    } else {
                        this.$router.push({ path: `/admin/tasks/new/`, query: { status: 'error' } });
                    }
                    
                    
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