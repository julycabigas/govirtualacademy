<template>
	<div class="video-new">
		
		<form @submit.prevent="add">
			<table class="table">
				<tr>
					<td width="300">Cover Photo</td>
					<td>
						<input type="file" @change="onFileSelected">
			
					</td>
				</tr>
				<tr>
					<th>Topic</th>
					<td>
						<input type="text" v-model="webinar.name" required>
					</td>
				</tr>
				<tr>
					<th>Host</th>
					<td>
						<input type="text" v-model="webinar.host" required>
					</td>
				</tr>
				<tr>
					<th>Description</th>
					<td>
						<vue-editor v-model="webinar.description" required></vue-editor>
					</td>
				</tr>
				<tr>
					<th>Date</th>
					<td>
						<input type="text" v-model="webinar.date" required>
					</td>
				</tr>
				<tr>
					<th>Time</th>
					<td>
						<input type="text" v-model="webinar.time" required>
					</td>
				</tr>
				<tr>
					<td>
						<router-link to="/admin/webinars" class="btn btn-cancel">Cancel</router-link>
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
				webinar: {
					name: '',
					description: '',
					date: '',
					time: '',
					image_url: '',
					host: ''
				},
				image: '',
				errors: null,
				categories: {},
				groupID: ''
			}
		},
		mounted() {
			axios.get(`/api/webinars/${this.$route.params.id}`)
					 .then((response) => {

					 	  this.webinar = response.data.webinar;
					 });
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		methods: {
			add() {
				this.errors = null;
				const constraints = this.getConstraints();
				const errors 	  = validate(this.$data.webinar, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}


				//Add new webinar
				axios.post(`/api/webinars/update/${this.$route.params.id}`, {  
					'webinar' : this.$data.webinar,
					'image'	: this.image, 
				   }, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {

                    //if successful go the list
                    if(response.data.webinar.id) {
                        this.$router.push('/admin/webinars');
                    }
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
							minimum: 5,
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