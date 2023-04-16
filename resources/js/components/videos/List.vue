<template>
	<div>
		<form class="form-search form-inline mb-3 text-right align-right" @submit.prevent="getResults">
			<input type="text" class="form-control mr-2" v-model="inputSearch" placeholder="search"/>
			<input type="submit"  class="form-control btn btn-primary" value="Search" />
		</form>
       <table class="table table-striped">
	       	<thead>
	       		<th>Title</th>
	       		<th>Course Name</th>
	       		<th>Action</th>
	       	</thead>
	       	<tbody>
	       		<template v-if="!videos">
	       			<tr>
	       				<td colspan="4" class="text-center">No Video Available</td>
	       			</tr>
	       		</template>
	       		<template v-else>
	       			<tr v-for="video in videos.data" :key="video.id">
	       				<td>{{ video.title }}</td>
	       				<td>{{ video.course.title }}</td>
	       				<td width="230">
	       					<router-link :to="`/videos/${video.id}`"  class="btn btn-custom btn-sm btn-primary">View</router-link>
	       					<router-link :to="`/admin/videos/edit/${video.id}`"  class="btn btn-custom btn-sm btn-success">Edit</router-link>
	       					<router-link :to="`/admin/videos/delete/${video.id}`"  class="btn btn-custom btn-sm btn-danger">Delete</router-link>
	       				</td>
	       			</tr>
	       		</template>	
	       	</tbody>
       </table>
       <pagination :data="videos" :limit="5" @pagination-change-page="getResults"></pagination>
	</div>
</template>

<script>
	export default {
		name: 'list',
		data() {
			return {
				videos: {},
				inputSearch: ''
			}
		},
		mounted() {
			this.getResults();
		},
		methods: {
			getResults(page = 1) {
				let keyword = this.inputSearch;
				if(keyword) {
					axios.get('/api/videos?page=' + page + '&keyword= ' + keyword,  {
							headers: { "Authorization" : `Bearer ${this.currentUser.token}`}
						})
						.then(response => {

							this.videos = response.data.videos;
						});
				} else {
					axios.get('/api/videos?page=' + page, {
							headers: { "Authorization" : `Bearer ${this.currentUser.token}`}
						})
						.then(response => {

							this.videos = response.data.videos;
						});
				}
				
			}
		},
		computed: {
			
			currentUser() {
				return this.$store.getters.currentUser;
			},


		}
		
	}
</script>