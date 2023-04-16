<template>
	<div class="container pb-3">
		<form @submit.prevent="update">

			<div class="form-group">
				<label for="name">Question</label>
				<vue-editor v-model="exam.question"></vue-editor>
			</div>

			<div class="form-group">
				<label for="description">Choice 1</label>
				<input type="text" class="form-control" v-model="exam.choice_1" />
			</div>
			<div class="form-group">
				<label for="description">Choice 2</label>
				<input type="text" class="form-control" v-model="exam.choice_2" />
			</div>
			<div class="form-group">
				<label for="description">Choice 3</label>
				<input type="text" class="form-control" v-model="exam.choice_3" />
			</div>
			<div class="form-group">
				<label for="description">Choice 4</label>
				<input type="text" class="form-control" v-model="exam.choice_4" />
			</div>
			<div class="form-group">
				<label for="answer">Answer</label>
				<input type="text" class="form-control" v-model="exam.answer" />
			</div>
			<div class="form-group">
				<label for="course">Course</label>
				
				<div v-if="courses">
					<select v-model="exam.course_id">
						<option value="" selected>Select course</option>
						<option v-for="course in courses" :key="course.id" :value="course.id" >{{ course.title }}</option>
					</select>
				</div>
				
			</div>
			<input type="submit" value="Submit" class="btn btn-primary">

			<div class="errors" v-if="errors">
				<ul>
					<li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
						<strong>{{ fieldName }}</strong> {{ fieldsError.join('\n') }}
					</li>
				</ul>
			</div>
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
				exam: {
					question: '',
					choice_1: '',
					choice_2: '',
					choice_3: '',
					choice_4: '',
					answer: '',
					course_id: ''
				},
				courses: {},
				errors: null,
			}
		},
		created() {
			this.getCourses();   	
			this.getExam();
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}

		},
		methods: {
			getCourses() {
				axios.get('/api/all-courses', {
					headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					}
				})
				.then(response => {
				
						this.courses = response.data.courses;
				});
			},
			getExam() {
				axios.get(`/api/examination/${this.$route.params.id}`, {
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					.then((response) => {
						this.exam = response.data.examination;
					})
					.catch((error) => {
						console.log(error);
					});
			},
			update() {

				this.errors = null;

				const constraints = this.getConstraints();

				const errors = validate(this.$data.exam, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}
				axios.post(`/api/examination/update/${this.$route.params.id}`, this.$data.exam, {
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					.then((response) => {
						this.$router.push('/admin/examination');
					})
					.catch((error) => {
						console.log(error);
					});


			},
			getConstraints() 
			{
				return  {
					question: {
						presence: true, 
						length: {
							minimum: 5,
							message: 'Must be at least 5 characters long'
						}
					},
					choice_1: {
                        presence: true, 
						length: {
							minimum: 5,
							message: 'Must be at least 5 characters long'
						}
					},
					choice_2: {
                        presence: true, 
						length: {
							minimum: 5,
							message: 'Must be at least 5 characters long'
						}
					},
					choice_3: {
                        presence: true, 
						length: {
							minimum: 5,
							message: 'Must be at least 5 characters long'
						}
					},
					choice_4: {
                        presence: true, 
						length: {
							minimum: 5,
							message: 'Must be at least 5 characters long'
						}
					},
					answer: {
                        presence: true, 
						length: {
							minimum: 1,
							message: 'Must be at least 1 characters long'
						}
					},

				}
			}
		}
	}
</script>