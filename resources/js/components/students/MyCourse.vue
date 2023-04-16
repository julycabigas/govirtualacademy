<template>
	<div class="content-wrap">
		<div class="pt-5 pb-5 auto-container">
			<!-- Start of Breadcrumb -->
			<div class="breadcrumb">
				
					<ul class="list-unstyled">
						<li><router-link to="/my-profile/dashboard">My Profile</router-link></li>
						<li><span>My Courses</span></li>
					</ul>
				
			</div>
			<!-- End of Breadcrumb -->
			<h1 class="pb-4 pt-3 font-weight-bold">Your Trainings</h1>
		    <template v-if="courseGroups">
				<div class="row row-group">
					<div class="col-sm-6 col-md-6 col-lg-6" v-for="item in courseGroups" :key="item.id"> 
						<div class="single-item-group">	
							<div class="img-holder">
								<img class="img-fluid" :src="`/images/${item.image}`" alt="training" />
							</div>
							
							<div class="info"> 
								<h2> {{ item.name }}</h2>
								<div class="desc">{{ item.description }}</div>
								<p>Level of difficulty: <span>{{item.level}}</span></p>
								<router-link :to="`/single-training/${item.id}`" class="btn btn-primary">
								    Start Training
								</router-link>
							</div>
						</div>	
					</div>	
				</div>	
			</template>				

		</div>
	</div>
</template>
<script>
	import Preloader from '../loader/Preloader.vue';

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
				courseGroups: []
			}
		},
		mounted() {
			this.getStudentCourses();
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
			getStudentCourses() {
				axios.get(`/api/course-group/${this.currentUser.id}`, {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
					.then((response) => {
							console.log(response.data.access);

							this.courseGroups = response.data.access;
					})
					.catch((error) => {
					  	  console.log(error);
					});
			},
		}
	}
</script>
<style scoped>
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
</style>