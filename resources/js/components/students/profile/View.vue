<template>
	<div class="inner-info profile-content pt-5">
		<!-- Start of Breadcrumb -->
		<div class="breadcrumb mb-2">
		
				<ul class="list-unstyled">
					<li><router-link to="/my-profile/dashboard">My Profile</router-link></li>
					<li><span>My Membership Info</span></li>
				</ul>
			
		</div>
		<!-- End of Breadcrumb -->
		<div class="row pt-5">
			<div class="col-lg-6 col-md-8 pt-3">

					<div class="main-area">
						 <div class="about-me-area">
							<h2 class="font-weight-bold">About Me</h2>
							<div class="text-block">
								<label>Full Name</label>	
								<p>{{ student.firstname }} {{ student.lastname }}</p>
							</div>
							<div class="text-block">
								<label>Email</label>	
								<p>{{ student.email }}</p>
							</div>
							<div class="text-block">
								<label>Mobile / Phone No.</label>	
								<p>{{ student.phone }}</p>
							</div>
							<div v-html="student.about"></div>
						</div>
					</div>

			</div>
			<div class="col-lg-3 col-md-3 pt-2">
				<!-- Start of Membership area -->
				<div class="side-area mt-2">
					 <div class="membership-area">
						<h2 class="font-weight-bold">Membership Info</h2>
						<div class="membership-area__detail">
							<div class="text-label">Current Membership</div>
							<div v-for="role in roles" :key="role.id">
								<div v-if="student.role == role.id" class="text-info">
								  {{ role.display_name }}
								</div>
							</div>
						</div>
						<div class="membership-area__detail">
							<div class="text-label">Joined Date</div>
							<div class="text-info"> {{ student.created_at }}</div>
						</div>
						<div class="membership-area__detail">
							<div class="text-label">Expiration Date</div>
							<div class="text-info">{{ student.updated_at }}</div>
						</div>
					</div>
				</div>
				<!-- End of Membership area -->
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		name: 'profile',
		created() {
			this.getStudent();
			this.getPosts();
			this.$store.dispatch('getRoles');
		},
		data() {
			return {
				student: {
					name: '',
					firstname: '',
					lastname: '',
					email: '',
					address: '',
					address_2: '',
					zipcode: '',
					municipality: '',
					about: null,
					role: '',
					image: 'user_image.png'
				},
				posts: []
			}
		},
		methods: {
			getStudent() {

				axios.get(`/api/students/${this.currentUserID}`, {
						headers: {
							"Authorization": `Bearer ${this.currentUserToken}`
						}
					})
					.then((response) => {
			
						this.student = response.data.student;
					})
					.catch((error) => {
						console.log(error);
					})

			},
			getPosts() {
				axios.get(`/api/posts/`)
					.then((response) => {
			
						this.posts = response.data.posts;
					})
					.catch((error) => {
						console.log(error);
					})
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