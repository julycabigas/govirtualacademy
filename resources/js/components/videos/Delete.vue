<template>
	<div class="video-new">
		<form @submit.prevent="update">
			<table class="table">
				<tr>
					<th>Title</th>
					<td>
						<input type="text" class="form-control" v-model="video.title">
					</td>
				</tr>
				<tr>
					<td>
						<router-link to="/videos" class="btn">Cancel</router-link>
					</td>
					<td>
						<input type="submit" value="Submit" class="btn btn-primary" />
					</td>
				</tr>
			</table>
		</form>
		
	</div>
</template>

<script>
	export default {
		name: 'delete',
		data() {
			return {
				video: {
					title: '',
					description: '',
					file: '',
					course_id: ''
				},
				errors: null,
			}
		},
		created() {

			axios.get(`/api/videos/${this.$route.params.id}`)
				 .then((response) => {
				 	 this.video = response.data.video;
				 })
				 .catch((error) => {
				 	console.log(error);
				 })
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			courses() {
				return this.$store.getters.courses;
			}
		},
		methods: {
			update() {

				axios.post(`/api/videos/delete/${this.$route.params.id}`,  {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
					this.$router.push('/admin/videos');
				})
			}
			
		}
	}
</script>

<style>
	.errors ul {
	    list-style: none;
	    padding: 0;
	    margin: 0;
	}
	.errors li {
	    background: #f3dcdc;
	    border-radius: 4px;
	    padding: 5px 10px;
	    margin-bottom: 5px;
	}
</style>