<template>
	<div class="lesson-single-view">
		<div class="">
			<div class="row meta-sect">
				<div class="col-md-8">
					<template v-if="isActiveBadges.length > 0">
						<span>This step is required for:</span>
						<div class="badges-group">
							<span class="badge-label" v-for="badge in isActiveBadges" :key="badge.id">
								<span>{{ badge.name }}</span>	
							</span>
						</div>
					</template>
				</div>
			</div>
		</div>
		<template v-if="has_lessons && !isLock">
			<div class="controls text-align-right">
					<span v-if="hideLesson">Show Lessons</span><span v-else>Hide Lessons</span>
					<button @click="toggleLesson()" class="btn btn-small btn-primary mt-2"> 
						<font-awesome-icon icon="bars" />
					</button>
			</div>

			<!-- Start of Video Player -->
			<div class="video-player" v-if="!isLock">
				<div class="grid">
					<div class="column video-player__main" v-bind:class="[{ nosidebar: hideLesson }]">
						<!-- Start of Video Wrapper -->
						<div class="video-wrapper">
							<vimeo-player ref="player" :options="options" :video-id="video" player-width="700"></vimeo-player> 
						</div>
						<!-- End of Video Wrapper -->
					</div>
					<div class="column video-player__sidebar" v-bind:class="[{ hide: hideLesson }]">
						<aside class="lesson-sidebar" v-if="lessons">
								<div class="lesson-item" v-for="(lesson, index) in lessons" :key="index" @click="changeVideo(lesson.file, lesson.description, index)" :class="{ 'active': isActive === index }">
									<strong><span class="index">{{ index + 1}}</span><span class="name">{{ lesson.title }}</span></strong>
								</div>	
						</aside>
					</div>
				</div>
			</div>
			<div v-else>
				<h4>Upgrade to continue</h4>
			</div>
			<!-- End of Video player -->

			<!-- Start of single-course -->
				<div class="single-course" v-if="course && !isLock">
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
				<!-- End of single-course -->
		</template>
		<template v-else>
			  <div class="alert alert-info">Lessons will be added soon!</div>	
		</template>

	</div>
</template>
<script>
	import { VueEditor } from 'vue2-editor';
	import Preloader from '../../loader/Preloader.vue';
	export default {
        name: 'lessons',
        props: ['courseID'],
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
				hideLesson: false,
				has_lessons: false,
				badges: [],
				hasLock: false
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
        },
        computed: {
			user_role() {
				return this.$store.getters.currentUser.role;
			},
			currentUser() {
				return this.$store.getters.currentUser;
            },
            isActiveCourse() {
				return this.$store.getters.activeCourse;
			},
			isActiveBadges() {
				return this.$store.getters.activeBadges;
			},
			isLock() {
				return this.$store.getters.isLock;
			}
        },
        watch: {
            isActiveCourse(value) {
                this.courseID = value;
                this.getLessons();
			},
			isActiveBadges(value) {
				return value;
			},
			isLock(value) {
				console.log(value);
				this.hasLock = value;
				return value;
			}
        },
		methods: {
            toggleLesson(){
                this.hideLesson = !this.hideLesson;
            },
			changeVideo(vimeoID, content, id) {

				this.video = vimeoID;
				this.course_content = content;
				this.isActive = id;
			},
			checkPermission() {

				axios.post(`/api/my-permission/${this.courseID}`, { 
				        user_id: this.currentUser.id }, {
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
				  .then((response) => {
				  		if(!response.data.has_permission) {
				  			//this.$router.push('/my-courses');
				  		}
				  })
				  .catch((error) => {
				  	  console.log(error);
				  });
			},
			getLessons() {
				axios.get(`/api/my-lessons/${this.courseID}`,{
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					  .then((response) => {
						  this.course = response.data.course;
						  this.lessons = response.data.lessons;
						  this.has_lessons = response.data.lessons.length > 0 ? true : false;
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
		}
	}
</script>
<style scoped>
    .controls {
        text-align: right;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }
    .controls span {
        margin-right: 5px;
    }
    .controls button.btn {
        min-width: auto;
        padding: 5px;
        line-height: 0;
        margin: 0 !important ;
    }
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
    .lesson-single-view .single-course {
        margin: 0;
        padding: 0;
	}
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
</style>