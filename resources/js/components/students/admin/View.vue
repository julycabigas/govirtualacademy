<template>
	<div class="inner-info">
		<table class="table table-striped">
			<tr>
				<th width="200">First Name</th>
				<td>{{ student.firstname }}</td>
			</tr>
			<tr>
				<th width="200">Last Name</th>
				<td>{{ student.lastname }}</td>
			</tr>
			<tr>
				<th width="200">Email</th>
				<td>{{ student.email }}</td>
			</tr>
			<tr>
				<th width="200">Address 1</th>
				<td>{{ student.address }}</td>
			</tr>
			<tr>
				<th width="200">Address 2</th>
				<td>{{ student.address_2 }}</td>
			</tr>
			<tr>
				<th width="200">Zipcode</th>
				<td>{{ student.zipcode }}</td>
			</tr>
			<tr>
				<th width="200">Municipality</th>
				<td>{{ student.municipality }}</td>
			</tr>
			<tr>
				<th width="200">Phone No. / Mobile No.</th>
				<td>{{ student.phone }}</td>
			</tr>
		</table>
		<div class="about-me-area">
			<h5>About Me</h5>
			{{ student.about }}
		</div>
	</div>
</template>
<script>
	export default {
		name: 'profile',
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
					about: ''
				}
			}
		},
		created() {
			this.getStudent();
		},
		methods: {
			getStudent() {

				axios.get(`/api/students/${this.$route.params.id}`)
					.then((response) => {
			
						this.student = response.data.student;
					})
					.catch((error) => {
						console.log(error);
					})

			}
		}
	}
</script>