<template>
	<div class="setting-area">

		 <form @submit.prevent="update">
		 		<table class="table">
		 			<tr v-for="setting in settings" :key="setting.id">
		 				<th>{{ setting.key}}</th>
		 				<td><input type="text" class="form-control" v-model="setting.value"></td>
		 			</tr>


		 			<tr>
		 				<th></th>
		 				<td><input type="submit" value="Save changes" class="btn btn-primary"></td>
		 			</tr>
		 		</table>	

		 </form>
	</div>
</template>
<script>
	export default {
		name: 'edit',
		data() {
			return {
				settings: [],
				setting: {
					id: '',
					key: '',
					value: ''
				}
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		mounted() {
			this.getSettings();

		},
		methods: {
			update() {
				axios.post('/api/settings/edit',  {

				})
				.then((response) => {
					console.log(response.data);
				})
			},
			getSettings() {
				axios.get('/api/settings', {
						headers: {
							"Authorization": `Bearer ${this.currentUser.token}`
						}
				})
				.then((response) => {
					console.log(response.data.settings[0]);
					this.settings = response.data.settings;
				})
				.catch((error) => {
					console.log(error);
				})
			}
		}
		
	}
</script>