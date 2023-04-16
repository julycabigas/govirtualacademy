<template>
	<div class="video-new">
		
		<form @submit.prevent="add">
			<table class="table">
				<tr>
					<th>Thumbnail</th>
					<td>
						<input type="file" @change="onFileSelected">
					</td>
				</tr>
				<tr>
					<th>Name</th>
					<td>
						<input type="text" v-model="course.name">
					</td>
				</tr>
				<tr>
					<th>Description</th>
					<td>
						<textarea type="text" v-model="course.description"></textarea>
					</td>
				</tr>
                <tr>
					<th>Level of difficulty (1,2,3)</th>
					<td>
						<input type="number" v-model="course.level">
					</td>
				</tr>
				<tr>
					<th>Access Levels</th>
					<td>
						<div v-for="access in allAccess" :key="access.id">
							<input type="radio" v-model="accessID" :value="access.id" /> {{ access.display_name }}
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<router-link to="/courses" class="btn btn-cancel">Cancel</router-link>
					</td>
					<td>
						<input type="submit" value="Submit" class="btn btn-primary" />
					</td>
				</tr>
			</table>
		</form>
		<div class="errors" v-if="errors">
			<ul>
				<li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
					<strong>{{ fieldName }}</strong> {{ fieldsError.join('\n') }}
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
	import validate from 'validate.js';
	import { VueEditor } from 'vue2-editor';

	export default {
		name: 'create',
		components: {
			VueEditor
		},
		data() {
			return {
				course: {
					name: '',
                    description: '',
                    level: '',  
				},
				image: '',
				checkRoles: [],
				errors: null,
				new_course: '',
                allAccess: [],
                accessID: ''
			}
		},
		mounted() {
            this.getAccessLevels();

			
		},
		created() { 
			axios.get(`/api/course-identifiers-group/${this.$route.params.id}`)
				 .then((response) => {
					  this.course = response.data.course;
					  this.accessID = response.data.course.course_id;
					  console.log(response.data);
				 })
				 .catch((error) => {
				 	console.log(error);
				 })
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			categories() {
				return this.$store.getters.categories;
			}
		},
		methods: {
			add() {
				this.errors = null;
				const constraints = this.getConstraints();
				const errors 	  = validate(this.$data.course, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}


				//Add new course
				axios.post(`/api/course-identifiers-group/update/${this.$route.params.id}`, {
						'image'	: this.image, 
						'course' : this.$data.course,
						'accessID' : this.accessID
				   }, 
				   {
					headers: { "Authorization": `Bearer ${this.currentUser.token}` }
					})
					.then((response) => {
					
						this.new_course = response.data.course.id;
						
						//if success go the list
						if(response.data.course.id) {
							this.$router.push('/admin/courses-group');
						}
					})
			},
			getAccessLevels() {
				axios.get('https://virtualacademy.ph/public/api/access-list/')
				 .then((response) => {
                     console.log(response.data.access_levels);
						this.allAccess = response.data.access_levels;
				 })	
			},
			onFileSelected(e) {
				let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
			},
			createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
			getConstraints() {
				return {
					name: {
						presence: true, 
						length: {
							minimum: 5,
							message: 'Must be at least 5 characters long'
						}
					},
					description: {
						presence: true, 
						length: {
							minimum: 10,
							message: 'Must be at least 10 characters long'
						}
					},

					
				}
			}
		}
	}
</script>

<style scoped>
	.errors ul {
	    list-style: none;
	    padding: 0;
	    margin: 0;
	}
	.errors li {
	    background: #f3dcdc;
	    border-radius: 4px;
	    padding: 5px 10px;
	    margin-bottom: 5px;
    }
    .btn.btn-cancel {
        border: 1px solid #222f3f;
    }
</style>