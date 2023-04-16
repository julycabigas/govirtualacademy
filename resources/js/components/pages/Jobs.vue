<template>
	<section class="page-content  d-padding mentor-area ">
		<div id="loader-front" v-if="loading">
	 		<div class="loading">
			    <Preloader />
			</div>
	 	</div>
		 <div class="container">
		 	<div class="row">
		 		<div class="col-md-10">
		 				<h1 class="font-weight-bold">Training to Employement</h1>
					 	<p>Sorry for the inconvenience, this page will be launched soon. Make sure you subscribe to our newsletter so you'll get updated. <br>For the meantime, keep yourself busy by learning our online digital courses!</p>
					 	
		 		</div>
		 	</div>
		 </div>
	</section>
</template>

<script>
	import Preloader from '../loader/Preloader.vue';
	export default {
		name: '404',
		components: { Preloader },
		data() {
			return {
				loading: false,
			}
		},
		mounted() {
			setTimeout(function(){
				this.loading = false;

			}, 1000);
			
		}
	}

</script>
<style scoped>
.mentor-area {
	min-height: 700px;
}
</style>