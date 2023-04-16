<template>
	<div class="video-new">
		<form @submit.prevent="update">
			<table class="table">
				<tr>
					<th>Title</th>
					<td>
						<input type="text" class="form-control" v-model="video.title">
					</td>
				</tr>
				<tr>
					<th>Description</th>
					<td>
						<input type="text" class="form-control" v-model="video.description">
					</td>
				</tr>
				<tr>
					<th>Vimeo Video Id</th>
					<td>
						<input type="text" class="form-control" v-model="video.file">
					</td>
				</tr>
				<tr>
					<th>Time (in seconds)</th>
					<td>
						<input type="text" class="form-control" v-model="video.time">
					</td>
				</tr>
				<tr>
					<th>Menu Order</th>
					<td>
						<input type="number" class="form-control" v-model="video.menu_order">
					</td>
				</tr>
				<tr>
					<th>Course</th>
					<td>
						<div v-if="courses">
							<select name=""  v-model="video.course_id" required>
								<option value="" selected>Select course</option>
								<option v-for="course in courses" :key="course.id" :value="course.id" >{{ course.title }}</option>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<router-link to="/videos" class="btn btn-md btn-outline">Cancel</router-link>
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
	export default {
		name: 'new',
		data() {
			return {
				video: {
					title: '',
					description: '',
					file: '',
					course_id: '',
					time: '',
					menu_order: 0
				},
				courses: {},
				errors: null,
			}
		},
		created() {

			axios.get(`/api/videos/${this.$route.params.id}`)
				 .then((response) => {
				 	 this.video = response.data.video;
				 })
				 .catch((error) => {
				 	console.log(error);
				 })

		},
		mounted() {
			this.allCourses();
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		methods: {
			allCourses() {
				axios.get(`/api/all-courses`, this.$data.video, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
					this.courses = response.data.courses;
				})
			},
			update() {
				this.errors = null;

				const constraints = this.getConstraints();

				const errors = validate(this.$data.video, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}

				axios.post(`/api/videos/update/${this.$route.params.id}`, this.$data.video, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
					this.$router.push('/admin/videos');
				})
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
					description: {
						presence: true, 
						length: {
							minimum: 3,
							message: 'Must be at least 3 characters long'
						}
					},
					course_id: {
						presence: true
					},
				}
			}
		}
	}
</script>

<style>
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