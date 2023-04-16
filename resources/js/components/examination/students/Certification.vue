<template>

	
	<div class="container pt-4">
		<!-- Start of Breadcrumb -->
		<div class="breadcrumb pl-3 pr-3">
			<ul class="list-unstyled">
				<li><router-link to="/my-courses">My Courses</router-link></li>
				<li><span>{{ course.title }} Exam Result</span></li>
			</ul>
		</div>
		<!-- End of Breadcrumb -->
		<!-- Start of Message -->
	    <div class="msg-alert mb-4">
			<div class="alert alert-success" v-if="message">
				{{ message }}
			</div>
		</div>
		<!-- End of Message -->
		<div v-if="result.has_passed">
			<h2 class="font-weight-bold pt-4 pb-4">Congratulations for passing the <span>'{{course.title}}'</span> exam.</h2>
			<h3>Your score is {{ score }}%</h3>
			<form @submit.prevent="request">
				<input type="submit" value="Request A Certificate" class="btn btn-success"/>
			</form>
		</div>
		<div v-else>
			<h2 class="font-weight-bold pt-4 pb-4">Sorry, you failed the <span>'{{course.title}}'</span> exam.</h2>
			<h3>Your score is {{ score }}%</h3>
			<p>You can try again after 2 days. For the meantime, please review this course.</p>
		</div>

	</div>
</template>
<script>
	export default {
		name: 'certification',
		data() {
			return {
				course: [],
				result: {},
				message: '',
				score: null
			}
		},
		mounted() {
			
				this.getResult();

		},
		methods: {
			getResult() {

				axios.get(`/api/results/${this.$route.params.id}`,{
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					  .then((response) => {
					  	
						  this.result = response.data.result;
						  this.score = Math.round(response.data.result.score);
				
						  if(this.result) {
						  	  this.getCourse();
						  } else {
						  	 this.$router.push('/my-courses');
						  }
		
					  })
					  .catch((error) => {
					  	  console.log(error);
					  });
			},
			getCourse() {
				axios.get(`/api/my-lessons/${this.result.course_id}`, {
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					  .then((response) => {
					  	
						  this.course = response.data.course;
		
					  })
					  .catch((error) => {
					  	  console.log(error);
					  });
			},
			request() {
				axios.post('/api/certification/new',  {
					'result_id': this.result.id,
					'emailed': false,
					'course_id': this.result.course_id,
					'user_id': this.currentUser.id,
					'student' : this.currentUser
				},{
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					.then((response) => {
						console.log(response);
						if(response.data.certification == false) {
							this.message = "You have requested a certificate already!";
						} else {
							this.message = "Request has been sent successfully! Please contact our team about this exam";
						}
					})
					.catch((error) => {
						console.log(error);
					});

			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		}
	}
	
</script>
<style scoped>
input[type=submit] {
    width: 100%;
    height: 45px;
	min-width: 168px;
	max-width: 200px;
    background: #f85b52;
    border-bottom: 3px solid #d43a31;
    border-color: #d43f36;
}
h2 span {
	color: #f85b52;	
}
</style>