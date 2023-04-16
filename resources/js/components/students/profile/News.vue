<template>
	<div class="inner-info profile-content">
		<div class="row">
			<div class="col-lg-12 col-md-12 pt-5 pb-5">
				<!-- Start of Breadcrumb -->
				<div class="breadcrumb">
				
						<ul class="list-unstyled">
							<li><router-link to="/my-profile/dashboard">My Profile</router-link></li>
							<li><span>Latest News</span></li>
						</ul>
			
				</div>
				<!-- End of Breadcrumb -->
					
				<h1 class="mt-4 mb-3 font-weight-bold">Latest News</h1>
				
				<article class="single-post card card-body mt-2 mb-2" v-for="post in postData.data" :key="post.id">
					<h2>{{ post.title }}</h2>
					<div v-html="post.content"></div>
				</article>
				
				<pagination :data="postData" @pagination-change-page="getResults"></pagination>
			</div>

		</div>
	</div>
</template>
<script>
	export default {
		name: 'latest-news',
		created() {
			this.getPosts();
		},
		data() {
			return {
				postData: {}, 
			}
		},
		mounted() {
			if(this.postData.length) {
				return;
			}
			this.$store.dispatch('getPosts');
			this.getResults();
		},
		methods: {

			getResults(page = 1) {
				axios.get('/api/posts?page=' + page)
					.then(response => {
						this.postData = response.data.posts;
					});
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