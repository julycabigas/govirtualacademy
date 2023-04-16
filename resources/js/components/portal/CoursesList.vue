<template>
	<div class="content-wrap">
		<div class="pt-5 pb-5 auto-container">

            <Breadcrumb v-bind:courseName="courseName" />

			<h3 class="loading-status">{{ status }}</h3>

			<div class="main-portal" v-if="courses.length">
				<div class="main-portal__sidebar">

					<div class="panel-wrapper">
						<template v-for="(course, index) in courses" :id="index">
							<template v-if="checkTrial(index)">
								<div class="single-panel"  
									v-bind:class="[index == 0 ? 'active' : '']" 
									:key="course.id" @click="getCourse(course.id, index, course.group_id, course.badges)" 
									>
									<h2>{{ doMath(index) }}</h2>
									<h3>{{ course.title }} </h3>

								</div>
							</template>
							<template v-else>
								<div class="single-panel"  
									v-bind:class="[index == 0 ? 'active disabled' : 'disabled']" 
									:key="course.id" @click="getCourse(course.id, index, course.group_id, course.badges)" 
									>
									<h2>{{ doMath(index) }}</h2>
									<h3>{{ course.title }} </h3>
									<font-awesome-icon icon="lock" />
								</div>
								
							</template>
						</template>
						
					</div>
					
				</div>
				<div class="main-portal__content">

					<ul class="nav nav-tabs" id="tab-portal" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="video-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="true">Training <font-awesome-icon icon="play-circle" /></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="tasks-tab" data-toggle="tab" href="#tasks" role="tab" aria-controls="tasks" aria-selected="false">Tasks <font-awesome-icon icon="tasks" /></a>
						</li>
						<li class="nav-item" v-if="has_exercise">
							<a class="nav-link" id="exercises-tab" data-toggle="tab" href="#exercises" role="tab" aria-controls="exercises" aria-selected="false">Exercises <font-awesome-icon icon="pencil-ruler" /></a>
						</li>
						<li class="nav-item" v-if="has_exam">
							<a class="nav-link" id="exam-tab" data-toggle="tab" href="#exam" role="tab" aria-controls="exam" aria-selected="false">Exam <font-awesome-icon icon="book" /></a>
						</li>
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="video" role="tabpanel" aria-labelledby="video-tab">
							<template v-if="selectedCourse">
								<Lessons  v-bind:courseID="selectedCourse" />
							</template>	
						</div>
						<div class="tab-pane fade" id="tasks" role="tabpanel" aria-labelledby="tasks-tab">
							<template v-if="selectedGroup">
								<Tasks  v-bind:groupID="selectedGroup" />
							</template>	
						</div>
						<div class="tab-pane fade" id="exercises" role="tabpanel" aria-labelledby="exercises-tab">
							<template v-if="selectedGroup">
								<Exercise  v-bind:groupID="selectedGroup" />
							</template>	
						</div>
						<div class="tab-pane fade" id="exam" role="tabpanel" aria-labelledby="exam-tab">
							<template v-if="selectedCourse">
								<Exam  v-bind:courseID="selectedCourse" />
							</template>	
						</div>
					</div>

				</div>
			</div>


		</div>
	</div>
</template>
<script>
	import Preloader from '../loader/Preloader.vue';
	import JQuery from 'jquery';
	import Breadcrumb from './parts/Breadcrumb.vue';
	import Lessons from './parts/Lessons.vue';
	import Tasks from './parts/Tasks.vue';
	import Exam from './parts/Exam.vue';
	import Exercise from './parts/Exercise.vue';
	export default {
		name: 'my-course',
		components: { Preloader, Breadcrumb, Lessons, Tasks, Exam, Exercise },
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
				selectedCourse: '',
				trial_step: '',
				activeCourse: '',
				selectedGroup: '',
				has_exercise: false,
				has_exam: false,
				selectedBadges: [],
				isLocked: false

			}
		},
		mounted() {
				this.getAllCourses();
				this.getFreeTrials();
				this.getCourseGroupName(); 	
				this.checkExercise();	
				this.checkExams();
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			currentUserToken() {
				return this.$store.getters.currentUser.token;
			},
			isActiveCourse() {
				return this.$store.getters.activeCourse;
			}
		},
		watch: {
			isActiveCourse(value) {
				return value;
			}
		},
		methods: {
			getCourse(course_id, index, group_id, badges) {
				let $ = JQuery;
				$('.single-panel').removeClass('active');
				$('#' + index).addClass('active');
				this.$store.dispatch('setActiveCourse', course_id);
				this.$store.dispatch('setActiveGroup', group_id);
				this.$store.dispatch('setActiveBadges', badges);
				
				this.selectedCourse = course_id;
				this.selectedGroup = group_id;
				this.selectedBadges = badges;

				this.checkExercise();
				this.checkExams();
				this.isLock(index);
				
			},
			doMath(index) {
				return index+1
			},
			isLock(index) {
				let num = index+1;
			  
			    if(this.trial_step >= num) {
					this.$store.dispatch('setLock', false);
				} else {
					this.$store.dispatch('setLock', true);
				}
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
						console.log(response.data.courses);
						   this.courses = response.data.courses;
						   if(response.data.courses.length > 0) {
							   this.selectedCourse = response.data.courses[0].id;
							   this.selectedGroup = response.data.courses[0].group_id;
							   this.selectedBadges = response.data.courses[0].badges;
							   this.$store.dispatch('setActiveGroup', this.selectedGroup);
							   this.$store.dispatch('setActiveCourse', this.selectedCourse);
							   this.$store.dispatch('setActiveBadges', this.selectedBadges);
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
			async checkExercise() {
			
				await axios.post(`/api/exercise-entry/check/${this.currentUser.id}`, {
							'group_id' : this.selectedGroup
					}, {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
					.then((response) => {
						if( response.data.exercises.length > 0) {
							this.has_exercise = true;
						} else {
							this.has_exercise = false;
						}
	
					})
					.catch((error) => {
							console.log(error);
					});
				
			},
			checkExams() {
				
				axios.get(`/api/examination/course/${this.selectedCourse}`, {
						headers: {
						  	 "Authorization" : `Bearer ${this.currentUserToken}`
						  }
					})
					.then((response) => {

						if(response.data.examinations.length > 0) {
							this.has_exam = true;
						}
						else {
							this.has_exam = false;
						}

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