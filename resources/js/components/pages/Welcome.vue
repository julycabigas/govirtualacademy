<template>	
	<div class="page-content d-padding contact-area">
			
			<div class="container">

				<h1 class="mb-3 text-center">Welcome New Students</h1>

                <div class="videoWrapper mt-3 mb-3">
                    <iframe src="https://player.vimeo.com/video/412034497" width="640" height="564" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                </div>

			</div>

	</div>
</template>

<script>
	export default {
		name: 'welcome'
	}

</script>
<style scoped>
.videoWrapper {
  position: relative;
  padding-bottom: 56.25%; /* 16:9 */
  height: 0;
}
.videoWrapper iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
@media ( min-width: 992px ) {
   .contact-area {
   	  min-height: 550px;
   }
}
</style>