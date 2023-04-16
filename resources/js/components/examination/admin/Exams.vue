<template>
	<div>
		<h5>Course Name: <br> <strong>{{ course.title }}</strong></h5>
       <table class="table table-striped exam">
	       	<thead>
	       		<th>Question</th>
	       		<th>Choices</th>
	       		<th>Answers</th>
	       		<th>Action</th>
	       	</thead>
	       	<tbody>
	       		<template v-if="!examinations.length">
	       			<tr>
	       				<td colspan="5" class="text-center">No exam is available</td>
	       			</tr>
	       		</template>
	       		<template v-else>
	       			<tr v-for="examination in examinations" :key="examination.id">
	       				<td><div v-html="examination.question"></div></td>
	       				<td><div  class="exam-choices" v-html="examination.choices"></div></td>
	       				<td class="exam-answer"><div v-html="examination.answer"></div></td>
	       				<td width="150">
	       					<router-link :to="`/admin/examination/edit/${examination.id}`" class="btn btn-custom btn-sm btn-success">Edit</router-link>
	       					<button class="btn btn-custom btn-sm btn-danger" v-on:click="deleteExam(examination.id)">Delete</button>
	       				</td>
	       			</tr>
	       		</template>	
	       	</tbody>
       </table>
	</div>
</template>

<script>
	export default {
		name: 'list-exam',
		data() {
			return {
				examinations: {
					question: '',
					choices: '',
					answer: '',
					course_id: ''
				},
				course: ''
			}
		},
		created() {

			this.exams();
			this.getCourse();

		},
		methods: {
			exams() {
				axios.get(`/api/examination/course/${this.$route.params.id}`, {

					headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					 }
				})
					 .then((response) => {
					 		this.examinations = response.data.examinations;
					 })
					 .catch(error => console.log(error));
			},
			getCourse: function() {
				axios.get(`/api/courses/${this.$route.params.id}`, {

						headers: {
						  	 "Authorization" : `Bearer ${this.currentUser.token}`
						 }
					})
					 .then((response) => {
					 		this.course = response.data.course;
					 })
					 .catch(error => console.log(error));
			},
			deleteExam: function(id) {
	
				axios.post(`/api/examination/delete/${id}`, {

						headers: {
						  	 "Authorization" : `Bearer ${this.currentUser.token}`
						 }
					})
					 .then((response) => {
					 		this.exams();
					 })
					 .catch(error => console.log(error));
			}
		},
		mounted() {
			if (this.courses.length) {
                return;
            }
			this.$store.dispatch('getCourses');
		},
		computed: {
			courses() {
				return this.$store.getters.courses;
			}, 
			currentUser() {
				return this.$store.getters.currentUser;
			}
		}
	}
</script>
<style scoped>
	.exam-choices p {
		display: inline;
		margin: 0;
	}
</style>