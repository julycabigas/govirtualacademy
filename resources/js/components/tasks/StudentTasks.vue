<template>
	<div class="content-wrap">
		<div class="container">
			<!-- Start of Breadcrumb -->
			<div class="breadcrumb">
				
					<ul class="list-unstyled">
						<li><router-link to="/admin/students">All Students</router-link></li>
                        <li>{{ student.firstname }} {{ student.lastname }}</li>
					</ul>
				
			</div>
			<!-- End of Breadcrumb -->
            <h3 class="course-group-title font-weight-bold">{{ courseName }}</h3>
			<div class="group-courses-list"> 

					<div class="row" v-if="courses.length">
						<div class="col-sm-12" v-for="(course, index) in courses" :key="course.id">
							
								<!-- Single Course Item Start -->
								<div class="single-course-item"> 
									<div class="group-single-item">
										<div class="course-content">
											<div class="row">
                                                <div class="col-md-10">
                                                    <h2>Step {{ doMath(index) }}</h2>
											       <h4>{{ course.title }}</h4>	
                                                </div>
												<div class="col-md-2">
													<template v-if="checkTrial(index)">
														<div class="trainer-profile" v-if="!course.note">
															<div class="course-cat text-capitalize text-right">
																<template v-if="course.tasks.length > 0">
																		<button v-on:click="checkComplete(course.group_id)" class="btn btn-primary btn-task">Tasks</button>
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
					<button v-on:click="showingTask()">Close X</button>
					<ul>
						<li v-for="(task, index) in tasklist" :key="task.id" v-bind:class="{'underline': task.completed }">
							<strong>Task {{doMath(index)}}</strong> - 
							
								{{task.name}} <br> 
								<template v-if="task.name != task.description">
									<div class="desc">
										{{ task.description}}
									</div>
								</template>
						</li>
					</ul>
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
                student: {}

			}
		},
		created() {
				this.getFreeTrials();
				this.getCourseGroupName(); 
                this.getAllCourses();
                this.getStudentInfo();
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
                    // Manually add id 9
					axios.get(`/api/course-identifiers-name/1`, {
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
				axios.get(`/api/course-identifiers/1`, {
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
			checkComplete(id) {

				let $ = JQuery;
				$('.task-list').addClass('show');
				
				axios.post(`/api/task-entry/check/${this.$route.params.id}`, {
							'group_id' : id
					}, {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
					.then((response) => {
						
						this.tasklist	= response.data.tasks;
					 
					})
					.catch((error) => {
					  	  console.log(error);
					});
				
            },
            getStudentInfo() {
				axios.get(`/api/students/${this.$route.params.id}`)
					.then((response) => {
					
						this.student = response.data.student;
					})
					.catch((error) => {
						console.log(error);
					})
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
	.badges-group {
		margin-bottom: 15px;
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
		padding-left: 56px;
		color: #8b8a8a;
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
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: rgba(0,0,0,0.6);
		display: none;
	}
	.task-list .inner-task {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		background: #fff;
		padding: 40px 20px 20px;
		min-width: 700px;
	}
	.inner-task .underline {
		text-decoration: line-through;
	}
	.inner-task button {
			position: absolute;
			top: 0;
			right: 0;
			border: 0;
			padding: 5px 10px;
			background: #c85454;
			color: #fff;
		}
	.task-list ul {
		list-style: none;
		padding: 0;
		margin: 0;
		max-height: 400px;
    	overflow-y: scroll;
	}
	.task-list ul li {
		margin-bottom: 10px;
		padding-bottom: 5px;
		border-bottom: 1px solid #f1eeee;
	}
	button.btn.btn-primary.btn-task {
        border-color: #222f3f;
        background-color: #222f3f;
    }
	button.btn.btn-primary.btn-task:hover {
		border-color: #062b48;
		background-color: #062b48;
	}
	.task-list {
		display: none;
	}
	.task-list.show {
			display: block !important;
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
		background: #fff;
		min-height: 450px;
	}
	a.btn.btn-secondary.btn-learn {
		background: #24adf3;
	}
	a.btn.btn-secondary.btn-learn:hover {
		background: #1169df;
    }
    .single-course-item .course-content {
        background: #fbfbfb;
    }
    .single-course-item {

        margin-bottom: 10px;
    }
	@media (max-width: 767px) {
		.task-list .inner-task {
			min-width: 500px;
		}
	}
	@media (max-width: 520px) {
		.task-list .inner-task {
			min-width: 300px;
		}
	}
</style>