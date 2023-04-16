<template>
	<div class="video-new">
		<div class="alert alert-success" v-if="$route.query.status == 'updated'">
			Course has been successfully updated!
			 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			 </button>
		</div>
		<form @submit.prevent="update">
			<table class="table">
				<tr>
					<th>Thumbnail</th>
					<td>
						<div class="row">
							<div class="col">
								<img :src="`/images/${course.image}`" width="300" />
							</div>
							<div class="col">
								<input type="file"  @change="onFileSelected">
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<th>Title</th>
					<td>
						<input type="text" v-model="course.title">
					</td>
				</tr>
				<tr>
					<th>Orig. Price</th>
					<td>
						<input type="text" v-model="course.orig_price">
					</td>
				</tr>
				<tr>
					<th>Discounted Price</th>
					<td>
						<input type="text" v-model="course.discount_price">
					</td>
				</tr>
				<tr>
					<th>Inclusions</th>
					<td>
						<vue-editor v-model="course.inclusions"></vue-editor>
					</td>
				</tr>
				<tr>
					<th>Short Description</th>
					<td>
						<textarea type="text" v-model="course.short_description"></textarea>
					</td>
				</tr>
				<tr>
					<th>What to learn</th>
					<td>
						<vue-editor v-model="course.learn"></vue-editor>
					</td>
				</tr>
				<tr>
					<th>Requirement</th>
					<td>
						<vue-editor v-model="course.requirement"></vue-editor>
					</td>
				</tr>
				<tr>
					<th>Description</th>
					<td>
						<vue-editor v-model="course.description"></vue-editor>
					</td>
				</tr>
				<tr>
					<th>Category</th>
					<td>
						<div v-if="categories">
						<select v-model="course.category_id">
							<option value="">Select category</option>
							<option  v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
						</select>
						</div>	
					</td>
				</tr>
				<tr>
					<th>Status</th>
					<td>
						
						<select v-model="course.status">
							<option value="">Select status</option>
							<option value="publish">Publish</option>
							<option value="draft">Draft</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Featured</th>
					<td>
						<input type="checkbox" v-model="course.featured" />
					</td>
				</tr>
				<tr>
					<th>Exam Countdown</th>
					<td>
						 (in seconds)
						<input type="number" min="60" max="7200" v-model="course.timer" />
					</td>
				</tr>
				<tr>
					<th>Rating <br></th>
					<td>
						<input type="text" name="rating" v-model="course.rating" required/>
					</td>
				</tr>
				<tr>
					<th>Passing Score<br></th>
					<td>
						<input type="number" name="passing_score" v-model="course.passing_score" />
					</td>
				</tr>
				<tr>
					<th>Total Students</th>
					<td>
						<input type="text" name="total_students" v-model="course.total_students" required/>
					</td>
				</tr>
				<tr>
					<th>Course Group/Identifier</th>
					<td>
						<div v-for="identifier in allCourseIdentifiers" :key="identifier.id">
							<input type="checkbox"  v-model="currentCourseGroup" :value="identifier.id" /> {{ identifier.name }}
						</div>
					</td>
				</tr>
				<tr>
					<th>Access Levels</th>
					<td>
						<div v-for="access in allAccess" :key="access.id">
							<input type="checkbox" v-model="checkRoles" :value="access.id" /> {{ access.display_name }}
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<router-link to="/courses" class="btn btn-outline">Cancel</router-link>
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
		name: 'new',
		components: {
			VueEditor
		},
		data() {
			return {
				course: {
					title: '',
					description: '',
					short_description: '',
					requirement: '',
					orig_price: '',
					discount_price: '',
					learn: '',
					inclusions: '',
					category_id: '',
					status: '',
					featured: '',
					timer: '',
					total_students: '',
					rating: '',
					passing_score: ''
				},
				image: '',
				checkRoles: [],
				currentCourseGroup: [],
				errors: null,
				allAccess: {},
				allCourseIdentifiers: {}
			}
		},
		created() {
			this.getCourse();
			this.getCourseAccess(); 	
		},
		mounted() {
			this.getAccessLevels();
			this.getCourseIdentifier();
			if(this.categories.length) {
				return;
			}
			this.$store.dispatch('getCategories');

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
			},
			access_levels() {
				return this.$store.getters.access_levels;
			}
		},
		methods: {
			getAccessLevels() {
				//axios.get('https://spiike.io/api/access-list')
				axios.get('/api/access-list')
				 .then((response) => {

						this.allAccess = response.data.access_levels;
				 	 
				 })	
			},
			update() {
				this.errors       = null;
				const constraints = this.getConstraints();
				const errors 	  = validate(this.$data.course, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}

				//Update course permission or access 
				axios.post(`/api/course-permission/update/${this.$route.params.id}`, {
					'role' :  this.$data.checkRoles
				}, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
						console.log(response.data);
				})


				//Update course group
				axios.post(`/api/course-identifiers/update/${this.$route.params.id}`, {
					'groups' :  this.$data.currentCourseGroup
				}, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
						console.log(response.data);
				})


				axios.post(`/api/courses/update/${this.$route.params.id}`, { 
					  'image'	: this.image,
					  'course'  : this.$data.course 
				    }, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {

					this.$router.push({ path: `/admin/courses/edit/${this.$route.params.id}`, query: { status: 'updated' } });
				})
			},
			getCourse() {
				axios.get(`/api/courses/${this.$route.params.id}`)
					 .then((response) => {

					 	  this.course = response.data.course;
					 });
			},
			getCourseIdentifier() {
			
				axios.get(`/api/all-course-identifiers`)
				 	.then((response) => {
						
						 this.allCourseIdentifiers = response.data.course_ids;

				})	
			},
			getCourseAccess() {
				axios.get(`/api/course-access/${this.$route.params.id}`)
				 .then((response) => {
				
				 	  for(let x = 0; x < response.data.access.length; x++) {
				 	  	  this.checkRoles[x] = response.data.access[x]['access_id'];
				 	  }
				 })	
			},
			addRole() {

				axios.post(`/api/course-permission/update/${this.$route.params.id}`, {
					 role: this.$data.checkRoles
				    }, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
					console.log(response.data);
				})
			},
			onFileSelected(e) {
				let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
			},
			createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
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
					orig_price: {
                           numericality: {
						      onlyInteger: true,
						      greaterThan: 0
						    
						 }
					},
					discount_price: {
                           numericality: {
						      onlyInteger: true,
						      greaterThan: 0
						    }
					},
					requirement: {
						presence: true, 
						length: {
							minimum: 10,
							message: 'Must be at least 30 characters long'
						}
					},
					inclusions: {
						presence: true, 
						length: {
							minimum: 10,
							message: 'Must be at least 30 characters long'
						}
					},
					learn: {
						presence: true, 
						length: {
							minimum: 10,
							message: 'Must be at least 30 characters long'
						}
					},
					description: {
						presence: true, 
						length: {
							minimum: 30,
							message: 'Must be at least 30 characters long'
						}
					}
					
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
</style>