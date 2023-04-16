<template>
	<div class="video-new">
		
		<form @submit.prevent="add">
			<table class="table">
				<tr>
					<th>Thumbnail</th>
					<td>
						<input type="file" @change="onFileSelected">
					</td>
				</tr>
				<tr>
					<th>Access Level slug (e.g fb for Facebook)</th>
					<td>
						<input type="text" v-model="course.access_slug">
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
						<input type="number" v-model="course.orig_price">
					</td>
				</tr>
				<tr>
					<th>Discounted Price</th>
					<td>
						<input type="number" v-model="course.discount_price">
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
					<th>Exam Countdown <br>(in seconds)</th>
					<td>
						<input type="number" name="timer" min="60" max="7200" v-model="course.timer" required/>
					</td>
				</tr>
				<tr>
					<th>Rating <br></th>
					<td>
						<input type="text" name="rating"  v-model="course.rating" required/>
					</td>
				</tr>
				<tr>
					<th>Total Students</th>
					<td>
						<input type="number" name="total_students" v-model="course.total_students" required/>
					</td>
				</tr>
				<tr>
					<th>Access Levels <br> This is required</th>
					<td>
						<div v-for="access in allAccess" :key="access.id">
							<input type="checkbox" v-model="checkRoles" :value="access.id" /> {{ access.display_name }}
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<router-link to="/courses" class="btn">Cancel</router-link>
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
					featured: null,
					timer: '',
					access_slug: '',
					total_students: '',
					rating: ''
				},
				image: '',
				checkRoles: [],
				errors: null,
				new_course: '',
				allAccess: []
			}
		},
		mounted() {
			this.getAccessLevels();
			if(this.categories.length) {
				return;
			}
			this.$store.dispatch('getCategories');


			
		},
		created() {
				axios.get(`/api/get-course-roles/${this.$route.params.id}`,{
						headers: {
							"Authorization": `Bearer ${this.currentUser.token}`
						}
				})
					 .then((response) => {
					
					 	  for(let x = 0; x < response.data.roles.length; x++) {
					 	  	  this.checkRoles[x] = response.data.roles[x]['role_id'];
					 	  }	 
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
				this.errors = null;
				const constraints = this.getConstraints();
				const errors 	  = validate(this.$data.course, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}


				//Add new course
				axios.post('/api/courses/new', {
					'image'	: this.image, 
					'course' : this.$data.course
				   }, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
				
					this.new_course = response.data.course.id;
					//new access
					if(response.data.course.id) {
						axios.post(`/api/course-permission/new`, {
							'course_id' : response.data.course.id,
							'role' :  this.$data.checkRoles
						}, {
							headers: {
								"Authorization": `Bearer ${this.currentUser.token}`
							}
						})
						.then((response) => {
							this.$router.push('/admin/courses');
						})
					}
				})
			},
			getAccessLevels() {
				axios.get(`/api/access-list`,{
						headers: {
							"Authorization": `Bearer ${this.currentUser.token}`
						}
				})
				 .then((response) => {
						this.allAccess = response.data.access_levels;
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
							minimum: 3,
							message: 'Must be at least 3 characters long'
						}
					},
					orig_price: {
                           numericality: {
						      onlyInteger: true,
						      greaterThan: 0
						 }
					},
					timer: {
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
							minimum:3,
							message: 'Must be at least 3 characters long'
						}
					},
					inclusions: {
						presence: true, 
						length: {
							minimum: 3,
							message: 'Must be at least 3 characters long'
						}
					},
					learn: {
						presence: true, 
						length: {
							minimum:3,
							message: 'Must be at least 3 characters long'
						}
					},
					description: {
						presence: true, 
						length: {
							minimum: 3,
							message: 'Must be at least 3 characters long'
						}
					},
					short_description: {
						presence: true, 
						length: {
							minimum: 3,
							message: 'Must be at least 3 characters long'
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