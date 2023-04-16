<template>
	<div>
       <table class="table table-striped">
	       	<thead>
	       		<th>Score</th>
	       		<th>Course Title</th>
	       		<th>Student's Name</th>
	       		<th>Emailed?</th>
	       		<th>Status</th>
	       	</thead>
	       	<tbody>
	       		<template v-if="!loading">
	       			<tr>
	       				<td colspan="5" class="text-center">Please wait</td>
	       			</tr>
	       		</template>
	       		<template v-else>
	       			<tr v-for="certificate in certificates.data" :key="certificate.id">
	       				<td>{{ certificate.result.score }}%</td>
	       				<template v-if="certificate.course">
	       					<td>{{  certificate.course.title }}</td>
	       				</template>
	       				<template v-if="certificate.user">
	       					<td>{{  certificate.user.firstname + ' ' +  certificate.user.lastname }}</td>
	       				</template>
	       				<td>{{ certificate.emailed ? "Yes":"Not Yet"}}</td>
	       				<td width="100">
	       					<div v-if="certificate.result.has_passed">Passed</div>
	       					<div v-else>Failed</div>
	       				</td>
	       			</tr>
	       			<tr v-if="!certificates.data">
	       				<td colspan="5">No Certifications Available</td>	
	       			</tr>
	       		</template>	
	       	</tbody>
       </table>
       <pagination :data="certificates" :limit="5" @pagination-change-page="allCertificates"></pagination>
	</div>
</template>

<script>
	export default {
		name: 'list-cert',
		data() {
			return {
				certificates: {},
				loading: false
			}
		},
		mounted() {

			this.allCertificates();
		},
		methods: {
			allCertificates(page = 1) {
					axios.get('/api/certification?page=' + page, {
 					 headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})		
					.then((response) => {
						console.log(response.data);
						this.certificates = response.data.certifications;
						if(this.certificates) {
							this.loading = true;
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