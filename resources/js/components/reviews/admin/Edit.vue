<template>
	<div class="course-delete">
		<form @submit.prevent="update">
			<table class="table">
				<tr>
					<th>Testimony</th>
				</tr>
				<tr v-if="review">
					
					<td v-if="!review.image">
			 	  		<img :src="`/users/${review.user.image}`" width="120" alt="User Image">
			 	  	</td>
			 	  	<td v-else>
			 	  		<img :src="`/images/${review.image}`" width="120" alt="Review Thumbnail">
			 	  		<input type="file"  @change="onFileSelected" >
			 	  	</td>
			 	  	
				
				</tr>
				<tr>
					<td>
						<label for="">Name</label>
						<input type="text" v-model="review.name" class="form-control" />
					</td>
				</tr>
				<tr>
					<td>
						<vue-editor  v-model="review.content"></vue-editor>
					</td>
				</tr>
				<tr>
						<input type="submit" value="Update" class="btn btn-primary" />
						<router-link to="/courses" class="btn">Cancel</router-link>
					</td>
				</tr>
			</table>
		</form>
		
	</div>
</template>

<script>
	import { VueEditor } from 'vue2-editor';
	export default {
		name: 'edit',
		components: {
			VueEditor
		},
		data() {
			return {
				review: {
					content: '',
					name: '',
					image: ''

				},
				image: '',
				errors: null,
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		mounted() {

			axios.get(`/api/reviews/${this.$route.params.id}`)
				 .then((response) => {
	
				 	 this.review = response.data.review;
				 })
				 .catch((error) => {
				 	console.log(error);
				 })
		},
		
		methods: {

			update() {

				axios.post(`/api/reviews/update/${this.$route.params.id}`,  {
					'image'	: this.image, 
					'review' : this.$data.review
				   }, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
					this.$router.push('/admin/reviews');
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
            }
			
		}
	}
</script>

<style>
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
</style>