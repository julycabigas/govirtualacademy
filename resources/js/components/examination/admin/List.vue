<template>
	<div>
       <table class="table table-striped">
	       	<thead>
	       		<th>Course Name</th>
	       		<th>Question</th>
	       		<th>Action</th>
	       	</thead>
	       	<tbody>
	       		<template v-if="!examinations">
	       			<tr>
	       				<td colspan="4" class="text-center">No exams available</td>
	       			</tr>
	       		</template>
	       		<template v-else>
	       			<tr v-for="examination in examinations.data" :key="examination.id">
	       				<td>{{ examination.course.title }}</td>
	       				<td><div v-html="examination.question"></div></td>
	       				<td width="130">
	       					<router-link :to="`/admin/examination/edit/${examination.id}`" class="btn btn-custom btn-sm btn-primary">Edit</router-link>
	       				</td>
	       			</tr>
	       		</template>	
	       	</tbody>
       </table>
       <pagination :data="examinations" @pagination-change-page="getExams"></pagination>
	</div>
</template>

<script>
	export default {
		name: 'list',
		data() {
			return {
				examinations : {}
			}
		},
		mounted() {
			this.getExams();
		},
		methods: {

			getExams(page = 1) {

				axios.get('/api/all-examination?page=' + page, {
					headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					}
				})
				.then(response => {
						this.examinations = response.data.examinations;
				});
		
			}

		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
		}
	}
</script>