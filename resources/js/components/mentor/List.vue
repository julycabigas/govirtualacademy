<template>
	<div class="student-list">
		<div class="alert alert-danger" v-if="$route.query.status == 'Deleted'">
			Student has been successfully deleted!
			 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			 </button>
		</div>
	    <table class="table table-striped" v-if="students">
	    	<thead>
	    	  <tr>
	    		<th>ID</th>
	    		<th>Full Name</th>
	    		<th>Email</th>
	    		<th>Action</th>
	    	  </tr>
	        </thead>
	        <tbody>
		    	<tr v-for="student in students.data" :key="student.id">
		    		<td>
						<div class="img-wrap-round">
							<template v-if="student.image != null">
							<img :src="`/users/${student.image}`" width="50" height="auto" /> <span class="caret"></span>
							</template>
							<template v-else>
							<img :src="'/images/user_image.png'" width="50" height="auto" /> <span class="caret"></span>
							</template>
						</div>
		    		</td>
		    		<td>{{ student.firstname }} {{ student.lastname }}</td>
		    		<td>{{ student.email }}</td>
		    		<td width="170">
		    			<router-link :to="`/admin/mentors/edit/${student.id}`"  class="btn btn-custom btn-sm btn-success">Edit</router-link>
						<router-link :to="`/admin/mentors/delete/${student.id}`"  class="btn btn-custom btn-sm btn-danger">Delete</router-link>
		    		</td>
		    	</tr>
	        </tbody>
	    </table>
	    <pagination :data="students" :limit="5" @pagination-change-page="getResults"></pagination>
	</div>
</template>
<script>
	export default {
		name: 'students-list',
		data() {
			return {
				students: {},
				status: ''
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		mounted() {
			// console.log(this.$route.params);
			this.getResults();
		},
		methods: {
			getResults(page = 1) {
				axios.get('/api/mentors?page=' + page, {
						headers: {
							"Authorization": `Bearer ${this.currentUser.token}`
						}
					})
					.then(response => {
						this.students = response.data.mentors;
					});
			}
		}
		
	}
</script>
<style scoped>
	a.btn.btn-custom.btn-sm.btn-tasks {
		background: #00BCD4;
		color: #fff;
	}
	img {
		border-radius: 50%;
	}
	.img-wrap-round {
		position: relative;
		width: 50px;
		height: 50px;
		overflow: hidden;
		border-radius: 50%;
	}
</style>