<template>
	<div>
		<form @submit.prevent="add">
			<table class="table">
				<tr>
					<td>
						<label for="">Image</label><br>
						<input type="file"  @change="onFileSelected" required>

					</td>
				</tr>
				<tr>
					<td>
						<label for="">Name</label><br>
						<input type="text" v-model="review.name" required>
					</td>
				</tr>
				<tr>
					<td>
						<vue-editor  v-model="review.content" required></vue-editor>
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" value="Create" class="btn btn-primary" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</template>
<script>
	import { VueEditor } from 'vue2-editor';
	export default {
		name: 'create',
		components: {
			VueEditor
		},
		data() {
			return {
				review: {
					name: '',
					content: ''
				},
				image: '',

			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		mounted() {

		},
		methods: {
			add() {

				//Add new course
				axios.post('/api/reviews/create', {
					'image'	: this.image, 
					'review' : this.$data.review
				   }, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then((response) => {
					
					if( response.data.status == true ) {
						this.$router.push('/admin/reviews');
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
            }
		}
	}
</script>