<template>
	<div class="video-new">
		<div class="alert alert-success" v-if="$route.query.status == 'updated'">
			Course has been successfully added to the group!
			 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			 </button>
		</div>
		<form @submit.prevent="add">
			<table class="table">
                <tr>
					<th>Group Identifiers</th>
					<td>
						<select v-model="groupID">
                            <option value="">Select Group</option>
						    <option  v-for="group in groupIdentifiers" :key="group.id" :value="group.id">{{ group.name }}</option>
						</select>
					</td>
				</tr>
				<tr>
					<th width="200">Course</th>
					<td>
						<select v-model="courseID">
                            <option value="">Select Course</option>
						    <option v-for="course in courses" :key="course.id" :value="course.id">{{ course.title }}</option>
						</select>
					</td>
				</tr>
                <tr>
					<th>Menu Order </th>
					<td>
                        <input type="number" v-model="menuID" placeholder="1"  required/>
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
                courses: [],
                courseID: '',
                groupIdentifiers: [],
                groupID: '',
                menuID: '',
				errors: null,
				new_course: '',
				allAccess: []
			}
		},
		created() {

				axios.get(`/api/all-course-identifiers`)
					 .then((response) => { 
					    this.groupIdentifiers = response.data.course_ids;     
                     });

                axios.get(`/api/all-courses`)
					 .then((response) => { 
					    this.courses = response.data.courses;     
                     })
                
                
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			categories() {
				return this.$store.getters.categories;
			},
			roles() {
				return this.$store.getters.roles;
			}
		},
		methods: {
			add() {

				//Add new course
				axios.post('/api/course-identifiers/new', { 
                    'courseID' : this.$data.courseID,
                    'groupID' : this.$data.groupID,
                    'menuID' : this.$data.menuID
				   }, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
                
                    console.log(response.data);
                    
                    if(response.data.status) {
                        this.$router.push({ path: `/admin/courses-group/new/`, query: { status: 'updated' } });
                        this.menuID = '';
                        this.courseID = '';
                    } else {
                        this.$router.push({ path: `/admin/courses-group/new/`, query: { status: 'error' } });
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