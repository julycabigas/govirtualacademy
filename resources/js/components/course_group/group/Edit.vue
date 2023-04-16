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
						<select v-model="group.course_identifiers_id">
                            <option value="">Select Group</option>
						    <option  v-for="group in groupIdentifiers" :key="group.id" :value="group.id">{{ group.name }}</option>
						</select>
					</td>
				</tr>
				<tr>
					<th width="200">Course</th>
					<td>
						<select v-model="group.course_id">
                            <option value="">Select Course</option>
						    <option v-for="course in courses" :key="course.id" :value="course.id">{{ course.title }}</option>
						</select>
					</td>
				</tr>
                <tr>
					<th>Menu Order </th>
					<td>
                        <input type="number" v-model="group.menu_order" placeholder="1"  required/>
					</td>
				</tr>
				<tr>
					<th>
						Badges
					</th>
					<td>
						<div v-for="badge in allBadges" :key="badge.id">
							<input type="checkbox" v-model="checkBadges" :value="badge.id" /> {{ badge.name }}
						</div>
					</td>
				</tr>
		  
                <tr>
					<th>Status  </th>
					<td> 
                        <label class="text text-success">(Add notification if this course is not yet ready)</label>
                        <input type="text" v-model="group.status"  />
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
                course: {},
                groupIdentifiers: [],
                groupID: '',
                menuID: '',
				errors: null,
				new_course: '',
				allAccess: [],
				checkBadges: [],
                group: {
                    menu_order: '',
                    course_id: '',
                    course_identifiers_id: '',
                    status: ''
				},
				allBadges: {} 
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

                axios.get(`/api/group-courses/${this.$route.params.id}`) 
                   .then((response) => {
                        this.group = response.data.group
                   })     
                
                
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		mounted() {
			this.getAllBadges();
			this.getCurrentBadges();
		},
		methods: {
			add() {

				//Badge
				axios.post(`/api/badge-req/update/${this.$route.params.id}`, {
					'badges' :  this.$data.checkBadges
				}, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
						console.log(response.data);
				})

				//Add new course
				axios.post(`/api/group-courses/update/${this.$route.params.id}`, { 
                      'group': this.$data.group
				   }, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
                
                   this.$router.push('/admin/all-groups');
 
				})
			},
			getCurrentBadges() {
				axios.get(`/api/badge-req/${this.$route.params.id}`)
				 .then((response) => {
					
				 	  for(let x = 0; x < response.data.badges.length; x++) {
				 	  	  this.checkBadges[x] = response.data.badges[x]['badge_id'];
				 	  }
				 })	
			},
			getAllBadges() {
   					axios.get('api/badges-list')
				 .then((response) => {
						this.allBadges = response.data.badges;
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