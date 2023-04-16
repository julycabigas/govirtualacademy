<template>
	<div>
		<div class="course-lesson-area">
		
				<table class="table table-striped" v-if="lessons.length">
					<thead>
						<tr>
							<th>Title</th>
							<th>Time</th>
							<th>Vimeo Id</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="lesson in lessons" :key="lesson.id">
							<td>{{ lesson.title }}</td>
							<td>{{ lesson.time }}</td>
							<td>{{ lesson.file }}</td>
						</tr>
					</tbody>
				</table>

		</div>
		<!-- Start of Breadcrumb -->
		<div class="breadcrumb">
			<div class="container">
				<ul class="list-unstyled">
					<li><router-link to="/admin/courses">Back to Courses</router-link></li>
					<li><span>Lesson</span></li>
				</ul>
			</div>
		</div>
		<!-- End of Breadcrumb -->
	</div>
</template>
<script>
	export default {
		name: 'tag',
		created() {

			if(this.videos.length) {
				console.log('test ' + this.$route.params.id);
				this.lesson = this.videos.find((video) => video.course_id == this.$route.params.id);
				console.log(this.lesson);
			} else {

				axios.get(`/api/video-by-course/${this.$route.params.id}`)
					 .then((response) => {
					 	this.lessons = response.data.videos;
					 	 console.log(response);
					 })
					 .catch((error) => {
					 	console.log(error);
					 })
			}
		},
		data() {
			return {
				lessons: [],
				lesson: {
					id: '',
					title: ''
				}
			}
		},
		methods: {
			add() {
				console.log('test');
			}
		},
		computed: {
			videos() {
				return this.$store.getters.videos;
			}
		}
	}
</script>