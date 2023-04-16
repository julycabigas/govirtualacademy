<template>
	<div v-if="certificate">
		<div class="message" v-if="message">
			<div class="alert alert-info">
				{{ message }}
			</div>
		</div>
		<div v-if="result">
			<span>Certificate Id: {{ certificate.id }}</span>
			<h2 class="font-weight-bold"> {{ certificate.course.title }}</h2>
			<h3>The student passed the exam</h3>

		</div>
	    <div v-else>

	    	<span>Certificate Id: {{ certificate.id }}</span>
			<h2> {{ certificate.course.title }}</h2>
			<h3>Sorry, the student failed the exam</h3>
	    </div>


		 <p class="mt-3">
			Student Name: {{ certificate.user.firstname }}  {{ certificate.user.lastname }}
		</p>

		<div v-if="result">
			<form @submit.prevent="EmailRequest">

				<input type="submit" value="Done" class="btn btn-primary" />
			</form>
		</div>
	</div>
	<div v-else>
		<h2 class="font-weight-bold">Certificate not found!</h2>
	</div>
</template>

<script>
	export default {
		name: 'approve-cert',
		data() {
			return {
				certificate: {
					title: '',
					id: '',
					course: {
						title: ''
					},
					user: {
						firstname: '',
						lastname: ''
					}
				},
				emailed: '',
				cert_id: '',
				loading: false,
				message: null,
				result: {}
			}
		},
		created() {

			this.allCertificates();
		},
		methods: {
			allCertificates(page = 1) {

					axios.get(`/api/certification/${this.$route.params.id}`, {
 					 headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})		
					.then((response) => {
						
						this.certificate = response.data.certification;
						this.result = response.data.certification.result.has_passed;
						console.log(this.result);
					})
					.catch((error) => {
						this.error = error.message;
					})
			},
			EmailRequest() {
				this.cert_id = 1;
				axios.post(`/api/certification/update/${this.$route.params.id}`, {
							'id': this.certificate.id,
							'emailed' : this.cert_id
					}, {
 					 headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})		
					.then((response) => {
						if(response.data.updated) {
							this.message = "Certificate has been successfully updated";
						}
					})
					.catch((error) => {
						this.error = error.message;
					})
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		}
	}
</script>