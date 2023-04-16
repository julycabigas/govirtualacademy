<template>
	<div class="student-list">
		<div class="alert alert-danger" v-if="$route.query.status == 'Deleted'">
			Student has been successfully deleted!
			 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			 </button>
		</div>
		<form class="form-search form-inline mb-3 text-right align-right" @submit.prevent="getResults">
			<input type="text" class="form-control mr-2" v-model="inputSearch" placeholder="search"/>
			<input type="submit"  class="form-control btn btn-primary" value="Search" />
		</form>
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
		    		<td width="290">
		    			<router-link :to="`/admin/students/${student.id}`"  class="btn btn-custom btn-sm btn-primary">View</router-link>
						<router-link :to="`/admin/students/tasks/${student.id}`"  class="btn btn-custom btn-sm btn-tasks">Tasks</router-link>
		    			<router-link :to="`/admin/students/edit/${student.id}`"  class="btn btn-custom btn-sm btn-success">Edit</router-link>
						<router-link :to="`/admin/students/delete/${student.id}`"  class="btn btn-custom btn-sm btn-danger">Delete</router-link>
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
				status: '',
				inputSearch: ''
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
				let keyword = this.inputSearch;
				if(keyword) {
					axios.get('/api/students?page=' + page + '&keyword= ' + keyword, {
						headers: {
							"Authorization": `Bearer ${this.currentUser.token}`
						}
					})
					.then(response => {
						console.log(response.data);
						this.students = response.data.students;
					});
				} else {
					axios.get('/api/students?page=' + page, {
						headers: {
							"Authorization": `Bearer ${this.currentUser.token}`
						}
					})
					.then(response => {
						this.students = response.data.students;
					});
				}
				
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