<template>
	<div class="container">
		<div class="inner-info profile-content">
			<div class="row">
				<div class="col-lg-12 col-md-12 pt-5">
					<!-- Start of Breadcrumb -->
					<div class="breadcrumb">
						<div class="container">
							<ul class="list-unstyled">
								<li><router-link :to="`/my-lessons/${course.id}`">{{course.title}}</router-link></li>
								<li><span>Examination</span></li>
							</ul>
						</div>
					</div>
					<!-- End of Breadcrumb -->
					<div class="msg-alert">
						<div class="alert mt-2" v-bind:class="{'alert-success': !has_failed,'alert-danger': has_failed }" v-if="has_message">
							{{ message }}
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-sm-12">
							<!-- Start of form -->
							<form @submit.prevent="add">
		                        <div class="wrap-exams" v-if="show_exam">
							
										<!-- Single Course Item Start -->
										<div class="single-exam" v-for="(exam, index) in exams" :key="exam.id" :id="exam.id">
											<div class="exam-wrap" v-if="index  == counter"> 
												<div  class="single-exam__question" v-html="exam.question"></div>
												<div class="single-exam__choices">
													<input type="radio" v-model="answers[index]" value="a" v-bind:id="exam.id + 'a'" v-bind:name="exam.id">
													<label v-bind:for="exam.id  + 'a'">{{ exam.choice_1 }}</label>
													
													<div class="check">
														<div class="inside"></div>
													</div>
													<!-- <input type="radio" v-model="answers[index]" value="a" /><span>{{ exam.choice_1 }}</span> -->
												</div>
												<div class="single-exam__choices">
													<input type="radio" v-model="answers[index]" value="b" v-bind:id="exam.id + 'b'" v-bind:name="exam.id">
													<label v-bind:for="exam.id  + 'b'">{{ exam.choice_2 }}</label>
													
													<div class="check">
														<div class="inside"></div>
													</div>
										
												</div>
												<div class="single-exam__choices">
													<input type="radio" v-model="answers[index]" value="c"  v-bind:id="exam.id + 'c'" v-bind:name="exam.id">
													<label v-bind:for="exam.id  + 'c'">{{ exam.choice_3 }}</label>
													<div class="check">
														<div class="inside"></div>
													</div>
												</div>
												<div class="single-exam__choices">
													<input type="radio" v-model="answers[index]" value="d"  v-bind:id="exam.id + 'd'" v-bind:name="exam.id">
													<label v-bind:for="exam.id  + 'd'">{{ exam.choice_4 }}</label>
													
													<div class="check">
														<div class="inside"></div>
													</div>
												</div>
											</div>
										</div>
										<!-- Single Course Item End -->
		    		 	 		</div>
								<div v-if="counter == endCount"> 
									<div class="form-group text-right">
										<input type="submit" class="btn btn-primary" value="Submit">
									</div>
								</div> 
							</form>
							<div class="row">
								<div class="col-md-6"><button v-if="exams.length > 1 && counter > 0" v-on:click="backTest()" class="btn btn-primary mb-2">Back</button></div>
								<div class="col-md-6 text-align-right"><button v-if="exams.length > 1 && counter < endCount" v-on:click="nextTest()" class="btn btn-secondary mb-2">Next </button></div>
							</div>
							
							
							<!-- End of form-->
						</div>
					</div>
					

				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import carousel from 'vue-owl-carousel';
	export default {
		name: 'latest-news',
		components: { carousel },
		data() {
			return {
				lessons: [],
				course: {
					id: null, 
					title: null,
					short_description: null,
					passing_score: null,
					timer:null,
				},
				category: '',
				exams: [],
				answer: {
					question_id: null,
					answer: null
				},
				questions: [],
				answers: [],
				message: '',
				has_message: false,
				has_failed: null,
				timer: 20,
				hours_timer: null, 
				minutes_timer: null, 
				seconds_timer: null,
				show_exam: false,
				exam_submitted: false,
				interval: '',
				counter: 0,
				endCount: 0
				
			}
		},
		created() {
			this.getCourse();
			this.getExams();			
			
		},
		methods: {
			add() {
				
				axios.post('/api/results/new', {
							'info' : this.$data.answers,
							'course_id' :  this.$data.course.id,
							'passing_score' :  this.$data.course.passing_score,
							'user_id' :  this.currentUserID,
							'exams' : this.exams,
							'total_questionnaire' : this.exams.length
					   }, {
							headers: { "Authorization" : `Bearer ${this.currentUserToken}`}
					  })
					  .then((response) => {
					
						  	if(response.data.result == false) {
						  		this.has_message = true;
						  		this.has_failed = true;
						  		this.message = "Sorry, you failed the exam. You score " + Math.round(response.data.score) +"%. Please try again next time.";
						  		this.$router.push(`/my-lessons/results/${response.data.results.id}`);
						  	} else {
						  		this.has_message = true;
						  		this.has_failed = false;
								this.message = "You succesfully passed the exam. You score " + Math.round(response.data.score) +"%. Certification will be sent to your email within 24 hours.";

								this.$router.push(`/my-lessons/results/${response.data.results.id}`);
						  	}
						  	this.exam_submitted = true;
					  })
					  .catch((error) => {
					  	  console.log(error);
					  });
			
			},	
			backTest() {
				if(this.counter > 0 ) {
					this.counter -= 1;
				}
			},
			nextTest() {
				if(this.counter < this.endCount ) {
					this.counter += 1;
				}
				console.log(this.counter);
			},
			getExams() {
				axios.get(`/api/examination/course/${this.$route.params.id}`, {
						headers: {
						  	 "Authorization" : `Bearer ${this.currentUserToken}`
						  }
					})
					.then((response) => {
				
						this.exams = response.data.examinations;
						this.show_exam = true;
						this.endCount = this.exams.length - 1;
						console.log(this.exams);
					})
					.catch((error) => {
						console.log(error);
					})
			},
			getCourse() {
				axios.get(`/api/my-lessons/${this.$route.params.id}`, {
					    headers: {
					  	 "Authorization" : `Bearer ${this.currentUserToken}`
					    }
					  })
					  .then((response) => {
					  		
						  this.course = response.data.course;

					  	  this.category = response.data.category;

					  	  	if( this.course ) {
								this.timer = this.course.timer;

								// if(!this.exam_submitted) {
								// 	this.interval = setInterval(() => {
								// 		this.countDown();
								// 	 }, 1000);
								// }
							}
					  })
					  .catch((error) => {
					  	  console.log(error);
					  });
			},
			countDown() {
				if(this.$data.timer < 1) {
					//this.$router.push({path: '/my-lessons/exam/results', query: { message:this.message }});
					//this.$router.push(`/my-lessons/${this.$data.course.id}`);
					//window.location = `/my-lessons/timer/${this.$route.params.id}`;
					//this.$router.push(`/my-lessons/timer/${this.$route.params.id}`);
				} else {

					let timer = this.$data.timer;
					let new_timer = timer - 1;

					let d = Number(new_timer);
				    let h = Math.floor(d / 3600);
				    let m = Math.floor(d % 3600 / 60);
				    let s = Math.floor(d % 3600 % 60);

				    let hours_t = h > 0 ? h + (h == 1 ? " hour, " : " hours, ") : "";
				    let minutes_t = m > 0 ? m + (m == 1 ? " minute, " : " minutes, ") : "";
				    let seconds_t  = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";

					this.$data.hours_timer   = hours_t;
					this.$data.minutes_timer = minutes_t;
					this.$data.seconds_timer = seconds_t;

					this.$data.timer = new_timer;
				}

			}
		},
		computed: {
			currentUserID() {
				return this.$store.getters.currentUser.id;
			},
			roles() {
				return this.$store.getters.roles;
			},
			currentUserToken() {
				return this.$store.getters.currentUser.token;
			}
		}
	}
</script>
<style scoped>
	.form-group.text-right .btn {
		position: absolute;
		right: 0;
		background: #81cb2b;
		border-color: #6fa432;
		z-index: 99;
	}
	.form-group.text-right {
		position: relative;
	}
	.text-align-right {
		text-align: right;
	}
	h1 {
		font-weight: 600;
		font-size: 20px;
	}
	.countdown {
	    display: inline-block;
	    font-weight: 600;
	    font-size: 20px;
	    color: #f85b52;	
	}
	.carousel .arrow.next {
	    right: 5px;
	    background: #f85b52;
	    color: #fff;
	    border-color: #f85b52;
	}
	.carousel .arrow.prev {
	    left: 5px;
	    background: #f85b52;
	    color: #fff;
	    border-color: #f85b52;
	}
</style>