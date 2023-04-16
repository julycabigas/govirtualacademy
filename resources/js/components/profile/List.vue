<template>
	<section class="page-content  d-padding student-area">
		<div id="loader-front" v-if="loading">
 			<div class="loading">
			    <Preloader />
			</div>
 		</div>
		 <div class="container">
		 	<h1>Virtual Assistant Warriors</h1>

		 	 <div class="mentors-list">

			 	 	<div class="row">
			 	 			
							<div class="col-md-3" v-for="student in students.data" :key="student.id">
								
						 	 		<div class="single-student">

							 	 		<div class="inner-wrap">
							 	 			<div class="image">
							 	 				<template v-if="student.image != null">
                                                  <img class="img-fluid"  :src="`/users/${student.image}`" alt=""/> 
                                                </template>
                                                <template v-else>
                                                  <img class="img-fluid" :src="'/images/user_image.png'" alt="" />
                                                </template>
						
							 	 			</div>
							 	 			<div class="info">
							 	 				<div class="info-block">
							 	 					<h4>{{ student.firstname }} {{ student.lastname }}</h4> 
								 	 				<span>{{ student.position }}</span>
							 	 				</div>
							 	 				
												
												<div class="action">
													<router-link :to="`/profile/${student.id}`" class="btn btn-secondary">View Profile</router-link>
												</div>
								 	 			
							 	 			</div>
								 	 		
								 	 	</div>

						 	 		</div>
						 		
							</div>

					</div>

					 <pagination :data="students" :limit="5" @pagination-change-page="getResults"></pagination>


		 	 	</div>
		 	 
		 	 </div>

	</section>

</template>

<script>
    import Preloader from '../loader/Preloader.vue';
	export default {
		name: 'students',
		components: { Preloader },
		data() {

			return {
				loading: true,
				students: {}

			}
			
		},
		mounted() {
			this.getResults();
		},
		methods: {
			getResults(page = 1) {
				axios.get('/api/all-students?page=' + page)
					.then(response => {
						this.students = response.data.students;
						this.loading = false;
					});
			},
		}
	}

</script>
<style scoped>
.action {
	margin-top: 20px;
	margin-bottom: 20px;
}
.mentors-list > .row > div {
	display: flex;
}
.single-student {
	width: 100%;
	display: flex;
}
.single-student .inner-wrap {
    text-align: center;
    background: #fff;
    box-shadow: 0 1px 5px #f2f2f7;
    border-radius: 6px;
	padding: 20px;
	margin-bottom: 15px;
	width: 100%;
}
.single-student .image {
    width: 150px;
    height: 150px;
    margin: 0 auto;
    overflow: hidden;
    border-radius: 50%;
}
.single-student .image img {
   object-fit: cover;
   width: 100%;
   height: 100%;
}
.single-student h4 {
	font-size: 1.2em;
	margin-top: 10px;
}
.single-student .btn {
    font-size: 14px;
    background: transparent;
    color: #f6961e !important;
    border: 2px solid #f6961e;
}
.single-student .btn:hover {
    background: #062b48;
    color: #fff !important;
    border: 2px solid #062b48;
}
</style>