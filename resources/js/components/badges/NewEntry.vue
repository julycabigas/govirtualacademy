<template>
	<div class="video-new">
		<div class="alert alert-success" v-if="$route.query.status == 'updated'">
			Badge has been successfully added to the student!
			 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			 </button>
		</div>
		<form @submit.prevent="add">
			<table class="table">
                <tr>
					<th>Badges</th>
					<td>
						<select v-model="badgeID">
                            <option value="">Select a badge</option>
						    <option  v-for="badge in badges" :key="badge.id" :value="badge.id">{{ badge.name }}</option>
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
					<th>Total Stars</th>
					<td>
                        <input type="number" v-model="star" placeholder="1" max="5"  required/>
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
				badges: {},
				star: 1,
				studentID: '',
				badgeID: ''
			}
		},
		created() {

				axios.get(`/api/badges-list`)
					 .then((response) => { 
					    this.badges = response.data.badges;     
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
				axios.post('/api/student-badges/new', { 
                    'badgeID' : this.$data.badgeID,
					'studentID' : this.$data.studentID,
					'star': this.$data.star
				   }, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
                
                    console.log(response.data);
                    
                    if(response.data.status) {
                        this.$router.push({ path: `/admin/badges/new/`, query: { status: 'updated' } });
						this.studentID = '';
						this.badgeID = '';
                    } else {
                        this.$router.push({ path: `/admin/badges/new/`, query: { status: 'error' } });
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