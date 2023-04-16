<template>

	
	<div class="container pt-4">
		<!-- Start of Breadcrumb -->
		<div class="breadcrumb pl-3 pr-3">
			<ul class="list-unstyled">
				<li><router-link to="/my-courses">My Courses</router-link></li>
			</ul>
		</div>
		<!-- End of Breadcrumb -->
		<!-- Start of Message -->
	    <div class="msg-alert mb-4 mt-3">
			<div class="alert alert-danger">
				Sorry, your time expires. Please try again later.
			</div>
			<router-link :to="`/my-lessons/${this.$route.params.id}`" class="btn btn-primary">Go back to the course</router-link>
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
		

		},
		methods: {

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
    max-width: 168px;
    background: #f85b52;
    border-bottom: 3px solid #d43a31;
    border-color: #d43f36;
}
h2 span {
	color: #f85b52;	
}
</style>