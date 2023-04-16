<template>
	<div class="lesson-list lesson-single-view">
		<div id="loader-front" v-if="loading">
 			<div class="loading">
			    <Preloader />
			</div>
 		</div>
		<!-- Start of Breadcrumb -->
		<div class="container pt-5">
			<div class="breadcrumb">
				<ul class="list-unstyled">
					<li><button class="btn btn-back" v-on:click="goBack()">Go Back</button></li>
		
				</ul>
			</div>
		</div>
		<!-- End of Breadcrumb -->
		<!-- Start of MEssage -->
		<div class="container pt-3">
			<div class="msg-alert">
				<div class="alert alert-danger mt-2" v-if="has_failed">
					You are temporary not allowed to retake the exam after failing it. You can take the exam after 1 week.
				</div>
			</div>
		</div>
		<!-- End of MEssage  -->
		<!-- Start of Sec Title -->
		<div class="course-view-info">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1>{{ course.title }}</h1>
						<p class="subtitle"><span>{{ category }}</span></p>
					</div>
					<!-- <div class="col-md-4 text-right pt-2" v-if="has_exam"> -->
					<!-- <div class="col-md-4 text-right pt-2">
				         <router-link :to="`/my-lessons/exam/${course.id}`" class="btn btn-primary" v-bind:class="{disabled:has_failed}" >Take An Exam</router-link> 	
					</div> -->
				</div>
				
			</div>
		</div>
		<!-- End of Sec Title -->
		
		<div class="container">
			<!-- Start of Video Player -->
			<div class="video-player">
				<div class="grid">
					<div class="column video-player__main">
						<!-- Start of Video Wrapper -->
						<div class="video-wrapper">
							<vimeo-player ref="player" :options="options" :video-id="video" player-width="700"></vimeo-player> 
						</div>
						<!-- End of Video Wrapper -->
					</div>
					<div class="column video-player__sidebar">
						<aside class="lesson-sidebar" v-if="lessons">
							  <div class="lesson-item" v-for="(lesson, index) in lessons" :key="index" @click="changeVideo(lesson.file, lesson.description, index)" :class="{ 'active': isActive === index }">
							  	 <strong><span class="index">{{ index + 1}}</span><span class="name">{{ lesson.title }}</span></strong>
							  </div>	
						</aside>
					</div>
				</div>
			</div>
			<!-- End of Video player -->
		</div>
			
		<div class="container">	
			<!-- Start of single-course -->
			<div class="single-course" v-if="course">
				<div class="grid">
					<div class="column">

						<!-- Start of video Content -->
						<div class="video-content">
							<h5>Additional Information</h5>
							<div class="single-course__content" v-html="course_content"></div>
						</div>
						<!-- End of video Content -->

					</div>	
				</div>
			</div>	
			
		</div>
		<!-- End of single-course -->


	</div>
</template>
<script>
	import { VueEditor } from 'vue2-editor';
	import Preloader from '../loader/Preloader.vue';
	export default {
		name: 'lessons',
		components: {
			VueEditor,
			Preloader
		},
		data() {
			return {
				lessons: [],
				course: '',
				hasPermission: false,
				video: 406720111,
				course_content: '',
				category: '',
				isActive:  0,
				has_failed: false,
				has_exam: false,
				has_taken_exam: false,
				review: '',
				message: false,
				loading: true,
				options: {
					  byline: false,
				      portrait: false,
				      title: false
				},
			}
		},
		created() {
			//check if has permission
			//check if category role is 6 or free
			//procced other checking
			this.checkPermission();

		},
		mounted() {

				this.getLessons()
				//this.checkTakenExam();
		},
		methods: {
			changeVideo(vimeoID, content, id) {

				this.video = vimeoID;
				this.course_content = content;
				this.isActive = id;
			},
			addReview() {
				axios.post(`/api/reviews/new`, {
						'user_id' : this.currentUser.id,
						'content' : this.review, 
						'approve' : false,
						'course_id' : this.$route.params.id
				    },{
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					.then((response) => {
					  	  let data = response.data;
					  	  this.review = '';	
						  this.message =  data.message;

					})
					.catch((error) => {
					  	  console.log(error);
					 });
			},
			checkTakenExam() {
				axios.post(`/api/my-results/${this.$route.params.id}`, {
					'user_id' : this.currentUser.id 
				    },{
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					.then((response) => {
					  	  let data = response.data;
					  	  console.log(data);
					  	  if( parseInt(data.exam_count) > 0 ) {
						  	this.has_exam =  true;
						  } 
						  if(data.result != null) {
							  if(parseInt(data.result.has_passed) === 0 ) {
							  	this.has_failed = true;
							  } 
						  }
						  if(data.can_take) {

						  	this.has_failed = false;
						  }
						  console.log(data);

					})
					.catch((error) => {
					  	  console.log(error);
					 });
			},
			checkPermission() {

				axios.post(`/api/my-permission/${this.$route.params.id}`, { 
				        user_id: this.currentUser.id }, {
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
				  .then((response) => {
				  		if(!response.data.has_permission) {
				  			this.$router.push('/my-courses');
				  		}
				  })
				  .catch((error) => {
				  	  console.log(error);
				  });
			},
			getLessons() {
				axios.get(`/api/my-lessons/${this.$route.params.id}`,{
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					  .then((response) => {
					  	  console.log(response.data);
						  this.course = response.data.course;
					  	  this.lessons = response.data.lessons;
					  	  this.course_content = response.data.lessons[0].description;
					  	  this.video = response.data.lessons[0].file || video;
					  	  this.category = response.data.category;
					  	  this.loading = false;	

					  })
					  .catch((error) => {
					  	  console.log(error);
					  });
			},
			goBack() {
				 window.history.back();
			}
		},
		computed: {
			user_role() {
				return this.$store.getters.currentUser.role;
			},
			currentUser() {
				return this.$store.getters.currentUser;
			}
		}
	}
</script>
<style scoped>
	.btn-back {
		background: #f6961e;
		color: #fff;
		border-color: #f6961e;
		border-bottom: 4px solid #f6961e;
	}
	.btn-back:hover { 
		border-color: #f6961e;
		border-bottom: 4px solid #c07618;
	}
	.display-flex {
		display: flex;
	}
	.col-left {
		width: calc(100% - 300px);
		padding-right: 50px;
	}
	.col-right {
		width: 300px;
	}
	.ql-editor {
	    background: #f5f5fa;
	}
	.single-course__content {
	    color: #707073;
	}
	.single-course h4 {
	    font-size: 22px;
	    font-weight: 600;
	    color: #393942;
	}
	.custom-container {
	    max-width: 1500px;
	    margin: 0 auto;
	}
</style>