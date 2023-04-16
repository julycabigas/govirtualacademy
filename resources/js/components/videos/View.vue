<template>
	<div class="video-view pl-2 pr-2" v-if="video">
		<div class="video-control">
			 <!-- Start of Video Player -->
			<div class="video-player">
				<div class="grid">
					<div class="column video-player__main">
						<!-- Start of Video Wrapper -->
						<div class="video-wrapper">
							<vimeo-player :video-id='videoShow' player-width="700"></vimeo-player> 
						</div>
						<!-- End of Video Wrapper -->
					</div>
				</div>
			</div>
			<!-- End of Video player -->
		</div>
		<div class="video-info pt-3 pb-3">
			 <h3>{{ video.title }}</h3>
			 <p>{{ video.description }}</p>
		</div>
		<!-- Start of Breadcrumb -->
		<div class="breadcrumb pl-3 pr-3">
			<ul class="list-unstyled">
				<li><router-link to="/admin/videos">Back to all videos</router-link></li>
				<li><span>{{ video.title }}</span></li>
			</ul>
		</div>
		<!-- End of Breadcrumb -->		
	</div>
</template>

<script>
	export default {
		name: 'view-videos',
		created() {
           if(this.videos.length) {

           		this.video = this.videos.find((video) => video.id == this.$route.params.id);

           } else {
           	  axios.get(`/api/videos/${this.$route.params.id}`, {
           	  	
           	  })
           	   .then((response) => {
           	       	this.video = response.data.video;
           	       	this.videoShow = this.video.file;
           	   })
           	   .catch(function(error) {
           	   	    if (error.response) {
				      console.log(error.response.data);
				      console.log(error.response.status);
				      console.log(error.response.headers);
				    } else if (error.request) {
				      console.log(error.request);
				    } else {
				      console.log('Error', error.message);
				    }
				    console.log(error.config);
           	   })
           }

		},
		data() {
			return {
				video: null,
				videoShow: ''
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			videos() {
				return this.$store.getters.videos;
			}
		},
		

	}
</script>
<style scoped>
.video-player__main {
    width: 100%;
}
.video-wrapper {
    padding-bottom: 56.25% !important;
 }
</style>