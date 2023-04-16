<template>
	<div class="content-wrap">
		<div class="pt-5 pb-5 container">
			<!-- Start of Breadcrumb -->
			<div class="breadcrumb">
				
					<ul class="list-unstyled">
						<li><router-link to="/my-courses">All Courses</router-link></li>
						<li><span>{{ courseName }}</span></li>
					</ul>
				
			</div>
			<!-- End of Breadcrumb -->
            <h1 class="course-group-title">{{ courseName }}</h1>
			<div class="group-courses-list"> 

					<div class="row" v-if="courses.length">
						<div class="col-sm-12" v-for="(course, index) in courses" :key="course.id">
							
								<!-- Single Course Item Start -->
								<div class="single-course-item"> 
									<div class="group-single-item">
										<!-- .single-thumb-area -->
										<div class="course-thumb-area">
											<img class="img-fluid" :src="`/images/${course.image}`" />
										</div>
										<!-- /.single-thumb-area -->
										<div class="course-content">
											<h2>Step {{ doMath(index) }}</h2>
											<h3>{{ course.title }}</h3>
											<div v-html="course.short_description"></div>	

											<div class="row meta-sect">
												<div class="col-md-8">
													<template v-if="course.badges.length > 0">
														<span>This step is required for:</span>
														<div class="badges-group">
															<span class="badge-label" v-for="badge in course.badges" :key="badge.id">
																<span>{{ badge.name }}</span>	
															</span>
														</div>
													</template>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<template v-if="checkTrial(index)">
														<div class="trainer-profile" v-if="!course.note">
															<div class="course-cat text-capitalize text-right">
																<router-link :to="`/my-lessons/${course.id}`" class="btn btn-secondary btn-learn">Learn Now <font-awesome-icon icon="play-circle" /></router-link>
																<template v-if="course.tasks.length > 0">
																		<button v-on:click="checkComplete(course.group_id, course.title)" class="btn btn-primary btn-task">Your Tasks <font-awesome-icon icon="tasks" /></button>
																</template>
																<template v-if="course.passing_score">
																	<router-link :to="`/my-lessons/exam/${course.id}`" class="btn btn-secondary btn-exam">Take An Exam <font-awesome-icon icon="pencil-ruler" /></router-link>
																</template>
															</div>
														</div>
														<div class="trainer-profile" v-else>
															<div class="course-cat text-capitalize text-right">
																<span class="note">{{ course.note }}</span>
															</div>
														</div>
													</template>	
													<template v-else>
														
														<div class="trainer-profile">
															<div class="course-cat text-capitalize text-right">
																<span class="note label label-danger">Upgrade to continue</span>
															</div>
														</div>
													</template>	
												</div>
											</div>
											

										</div>
										<!-- /.course content -->
									</div>
								</div>
								<!-- /.single-course-item -->

						</div>
					</div>
					<br>
					<h3>{{ status }}</h3>
			</div>
			<div class="task-list">
				<div class="inner-task">
					<h4>{{ activeCourse }} <button v-on:click="showingTask()">Close</button></h4>
					<div class="inner-list">
						<ul>
							<li v-for="(task, index) in tasklist" :key="task.id" v-bind:class="{'underline': task.completed }">
								<strong>Task {{doMath(index)}}</strong> <span v-bind:class="{'underline': task.completed }">{{task.name}}</span> 
									<template v-if="task.name != task.description">
										<div class="desc">
											<div v-html="task.description"></div>
											<template v-if="task.notes">
												<div class="task-note">
													<div v-html="task.notes"></div>	
												</div>
											</template>
										</div>
									</template>
							</li>
						</ul>
					</div>
					
				</div>
			</div>

		</div>
	</div>
</template>
<script>
	import Preloader from '../loader/Preloader.vue';
	import JQuery from 'jquery';
	export default {
		name: 'my-course',
		components: { Preloader },
		data() {
			return {
				courses: [],
				role: '',
				free_courses: [],
				role_name: '',
				access: [],
				loading: true,
				courseGroups: [],
				courseName: '',
				status: 'loading...',
				taskStatus: false,
				tasklist: {},
				courseID: '',
				trial_step: '',
				activeCourse: ''

			}
		},
		created() {
				this.getFreeTrials();
				this.getCourseGroupName(); 
				this.getAllCourses();
		},
		mounted() {
			
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			currentUserToken() {
				return this.$store.getters.currentUser.token;
			}
		},
		methods: {
			doMath(index) {
				return index+1
			},
			checkTrial(index) {
				let num = index+1;
			  
			    if(this.trial_step >= num) {
					return true;
				} else {
					return false;
				}

			},
			showingTask() {
				let $ = JQuery;
				$('.task-list').removeClass('show');
				this.tasklist = "";

			},
			getCourseGroupName() {
					axios.get(`/api/course-identifiers-name/${this.$route.params.id}`, {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
					.then((response) => {

					  	 this.courseName  = response.data.name;
					})
					.catch((error) => {
					  	  console.log(error);
					});
			},
			getAllCourses() {
				axios.get(`/api/course-identifiers/${this.$route.params.id}`, {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
					.then((response) => {
						   this.courses  = response.data.courses;
							console.log(response.data.courses);
						   if(response.data.courses.length > 0) {
							   this.status = '';
						   } else {
							   this.status = 'Coming soon!'
						   }
					})
					.catch((error) => {
					  	  console.log(error);
					});
			},
			checkComplete(id, course) {

				let $ = JQuery;
				$('.task-list').addClass('show');
				
				axios.post(`/api/task-entry/check/${this.currentUser.id}`, {
							'group_id' : id
					}, {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
					.then((response) => {
		
						this.tasklist	= response.data.tasks;
						this.activeCourse = course;
					 
					})
					.catch((error) => {
					  	  console.log(error);
					});
				
			},
			getFreeTrials() {
				axios.post(`/api/free-trial/update/${this.currentUser.id}`, {
					    'course_id' : this.$route.params.id
				}, {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
					.then((response) => {
						   
						   
						   if(response.data.trial != null) {
							   this.trial_step  = response.data.trial;
						   } else {
							   //will show all courses
							   this.trial_step  = 300;
						   }
						   console.log(this.trial_step);
							
					})
					.catch((error) => {
					  	  console.log(error);
					});
			}

		}
	}
</script>
<style scoped>
	.task-note {
		padding-top: 5px;
		border-top: 1px dashed #ddd;
		margin-right: 5px;
	}
	.group-single-item {
		display: flex;
		background: #fff;
		box-shadow: 0 10px 20px #dcdcef;
		border-radius: 9px;
		overflow: hidden;
	}
	.course-group-title {
		margin-top: 30px;
		margin-bottom: 10px;
		text-transform: uppercase;
		font-size: 1.9rem;
	}
	.badges-group {
		margin-bottom: 15px;
		opacity: 0.7;
	}
	span.badge-label {
		display: inline-block;
		padding: 3px 10px;
		background: #fee1be;
		margin-right: 6px;
		border-radius: 4px;
		font-weight: 600;
		font-family: 'poppins', sans-serif;
		font-size: 14px;
		color: #062b48;
		margin-bottom: 5px;
	}
	span.badge-label:nth-child(1) {
		background: #fee1be;
	}
	span.badge-label:nth-child(2) {
		background: #baf5d8;
	}
	span.badge-label:nth-child(3) {
		background: #d1e4f3;
	}
	span.badge-label:nth-child(4) {
		background: #baebfc;
	}
    .desc {
		padding-left: 63px;
		color: #0e0e0e;
	}  
	span.note {
		font-size: 18px;
		display: inline-block;
		padding: 5px 10px;
		color: #062b48;
	}
	.task-list {
		position: fixed;
		top: 0;
		right: -100%;
		width: 500px;
		height: 100%;
		z-index: 9999;
		background: #fff;
		box-shadow: 0 2px 30px rgba(68, 66, 66, 0.3);
		transition: right 0.3s ease;
	}
	.task-list .inner-task {
		position: absolute;
		top: 0;
		background: #fff;
		min-width: 100%;
	}
	.task-list ul li:after {
		content: '';
		display: block;
		clear: both;
	}
	.task-list ul li strong {
		float: left;
		background: #eaeceb;
		color: #000;
		padding: 5px;
		border-radius: 3px;
		font-size: 15px;
		font-weight: 500;
	}
	.task-list ul li span {
		padding-left: 63px;
		display: block;
		font-weight: 600;
	}
	.task-list .inner-task .inner-list {
		padding: 10px;
	}
	.inner-task h4 {
		background: #000000;
		color: #fff;
		padding: 15px;
		font-size: 21px;
		position: relative;
		display: flex;
		align-items: center;
		justify-content: space-between;
	}
	.inner-task .underline {
		text-decoration: line-through;
	}
	.inner-task button {
		border: 0;
		padding: 5px 10px;
		background: #e43c3c;
		color: #fff;
		border-radius: 4px;
		font-size: 13px;
		font-weight: 600;
	}
	.task-list ul {
		list-style: none;
		padding: 0;
		margin: 20px 0;
		max-height: 700px;
		overflow-y: scroll;
	}
	.task-list ul li {
		margin-bottom: 10px;
		padding-bottom: 5px;
		padding-right: 5px;
		border-bottom: 1px solid #f1eeee;
		word-break: break-word;
	}
	button.btn.btn-primary.btn-task {
		border-color: #f6961e;
		background-color: #f6961e;
	}
	button.btn.btn-primary.btn-task:hover {
		border-color: #062b48;
		background-color: #062b48;
	}
	a.btn.btn-secondary.btn-exam {
		pointer-events: none;
		opacity: 0.3;
	}
		.task-list.show {
		right: 0;
	}
	h2 {
		font-weight: 600;
	}
	h3 {
		margin-bottom: 20px;
	}
	.my-courses-list {
		margin-bottom: 30px;
	}
	.content-wrap {
		background: #f5f5fa;
		min-height: 450px;
	}
	a.btn.btn-secondary.btn-learn {
		background: #f14a0a;
	}
	a.btn.btn-secondary.btn-learn:hover {
		background: #062b48;
	}
	.group-single-item .course-content .btn {
		margin-bottom: 5px;
	}
	@media (max-width: 767px) {
		.task-list .inner-task {
			min-width: 500px;
		}
		.task-list {
			width: 100%;
			right: 150%;
		}
	}
	@media (max-width: 520px) {
		.task-list .inner-task {
			min-width: 300px;
			width: 100%;
		}
	}
	@media (max-height: 700px) {
		.task-list ul {
			overflow-y: scroll;
			max-height: 400px;
		}
	}
	@media (max-height: 500px) {
		.task-list ul {
			overflow-y: scroll;
			max-height: 200px;
		}
	}
</style>