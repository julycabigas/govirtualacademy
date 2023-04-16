<template>
	<div class="inner-info profile-content">
		<div class="row">
			<div class="col-lg-12 col-md-12 pt-3">
				<!-- Start of Breadcrumb -->
				<div class="breadcrumb">
				
						<ul class="list-unstyled">
							<li><router-link to="/my-profile/dashboard">My Profile</router-link></li>
							<li><span>Examinations</span></li>
						</ul>
			
				</div>
				<!-- End of Breadcrumb -->
					
				<h2 class="mt-5 mb-5 font-weight-bold">Exam Results</h2>
					
				<div class="results-wrapper" v-if="results.length">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Title</th>
								<th>Score</th>
								<th>Passed</th>
								<th width="250">Date</th>
						    </tr>
						</thead>
						<tbody>
							<tr v-for="(result, index) in results" :key="index">
								<td>{{result.title}}</td>
								<td>{{result.score}}%</td>
								<td>{{ result.has_passed ? 'passed' : 'failed'}}</td>
								<td>{{ result.created_at }}</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div v-else>
					<p>You don't have any examination yet!</p>
				</div>

			</div>

		</div>
	</div>
</template>
<script>
	export default {
		name: 'exam',
		data() {
			return {

				results: []
			}
		},
		created() {
			this.getMyExam();
		},
		mounted() {
			if( this.isMentor || this.isEmployer ) {
				this.$router.push('/');
			}
		},
		methods: {

			getMyExam() {
				axios.get(`/api/results/student-exams/${this.currentUserID}`,{
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUserToken}`
					  }
					})
					.then((response) => {
						console.log(response.data);
						this.results = response.data.results;
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
			},
			isMentor() {
                return this.$store.getters.currentUser.role == 8 ? true: false;
            },
            isEmployer() {
                return this.$store.getters.currentUser.role == 9 ? true: false;
            }
		}
	}
</script>