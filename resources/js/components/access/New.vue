<template>
	<div class="container">
		<div class="errors" v-if="errors">
			<ul>
				<li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
					<strong>{{ fieldName }}</strong> {{ fieldsError.join('\n') }}
				</li>
			</ul>
		</div>
		<form @submit.prevent="add" class="mt-2">

			<div class="form-group">
				<label for="name">Thumbnail</label><br>
				<input type="file" @change="onFileSelected">
			</div>

			<div class="form-group">
				<label for="name">Name</label>
				<input id="name" type="text" v-model="access.name">
			</div>


			<div class="form-group">
				<label for="display_name">Display Name</label>
				<input id="display_name" type="text" v-model="access.display_name">
			</div>


			<div class="form-group">
				<label for="re_price">Regular Price (Php)</label>
				<input id="re_price" type="number" v-model="access.reg_price">
			</div>


			<div class="form-group">
				<label for="re_price">Regular Price (Php)</label>
				<input id="re_price" type="number" v-model="access.discount_price">
			</div>


			<div class="form-group">
				<label for="sd">Short Description</label>
				<input id="sd" type="text" v-model="access.short_description">
			</div>

			<div class="form-group">
				<label for="sd">Description</label>
				<textarea v-model="access.description" cols="30" rows="10"></textarea>
			</div>

			<div class="form-group">
				<label>Type</label>
				<select v-model="access.type">
					<option value="">Select Type</option>
					<option value="bundle">Bundle</option>
					<option value="single">Single</option>
				</select>
			</div>


			<input type="submit" value="Submit" class="btn btn-primary">

		</form>

	</div>
</template>
<script>
	import validate from 'validate.js';
	export default {
		name: 'new',
		data() {
			return {
				access: {
					name: '',
					display_name: '',
				},
				errors: null,
				image: ''
			}
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

				const errors = validate(this.$data.access, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}
				axios.post('/api/access/new', {
							'access' : this.$data.access,
							'image' : this.image, 
				     }, {
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					.then((response) => {
						this.$router.push('/admin/training');
					})
					.catch((error) => {
						console.log(error);
					});
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
			getConstraints() 
			{
				return  {
					name: {
						presence: true, 
						length: {
							minimum: 1,
							message: 'Must be at least 3 characters long'
						}
					},
					display_name: {
                        presence: true, 
						length: {
							minimum: 3,
							message: 'Must be at least 3 characters long'
						}
					}
				}
			}
		}
	}
</script>