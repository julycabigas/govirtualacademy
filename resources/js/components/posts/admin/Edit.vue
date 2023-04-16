<template>
	<div class="container">

		<form @submit.prevent="update">

			<div class="form-group">
				<label for="name">Title</label>
				<input id="name" type="text" v-model="post.title" class="form-control">
			</div>

			<div class="form-group">
				<label for="description">Content</label>
				<vue-editor v-model="post.content"></vue-editor>
			</div>
			<div class="form-group">
					<label for="status">Status</label>
					<select id="status" v-model="post.status" class="form-control">
						<option value="">Select status</option>
						<option value="publish">Publish</option>
						<option value="draft">Draft</option>
					</select>
			</div>	

			<input type="submit" value="Submit" class="btn btn-primary">

			<div class="errors" v-if="errors">
				<ul>
					<li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
						<strong>{{ fieldName }}</strong> {{ fieldsError.join('\n') }}
					</li>
				</ul>
			</div>
		</form>
	</div>
</template>
<script>
	import validate from 'validate.js';
	import { VueEditor } from 'vue2-editor';
	export default {
		name: 'edit',
		components: {
			VueEditor
		},
		data() {
			return {
				post: {
					title: '',
					content: '',
					status: ''
				},
				errors: null
			}
		},
		mounted() {
			this.getPost();
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		methods: {
			getPost() {
				axios.get(`/api/posts/${this.$route.params.id}`)
					 .then((response) => {
					 	this.post = response.data.post;
					 })
			},
			update() {

				this.errors = null;

				const constraints = this.getConstraints();

				const errors = validate(this.$data.post, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}
				axios.post(`/api/posts/update/${this.$route.params.id}`, this.$data.post, {
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					.then((response) => {
						this.$router.push('/admin/posts');
					})
					.catch((error) => {
						console.log(error);
					});
			},
			getConstraints() 
			{
				return  {
					title: {
						presence: true, 
						length: {
							minimum: 5,
							message: 'Must be at least 5 characters long'
						}
					},
					content: {
                        presence: true, 
						length: {
							minimum: 5,
							message: 'Must be at least 5 characters long'
						}
					}
				}
			}
		}
	}
</script>