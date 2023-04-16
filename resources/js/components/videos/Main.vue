<template>
	
    <div class="home-content d-padding">

		<div class="container">
			<div class="row">
				<div class="col-lg-2 col-md-12">
					
					<Sidebar/>

				</div>
				<div class="col-lg-10 col-md-12">
					
					<!-- Start of Home Main Content -->
					<div class="home-main-content">
						<div class="card">
							<div class="card-header">
								Lessons
							</div>
							<div class="card-body">
								<router-view></router-view>	
							</div>
						</div>
					</div>
					<!-- End of Home Main Content -->
					
				</div>
			</div>
		</div>
    </div>
	
</template>

<script>
	import Sidebar from '../home/Sidebar.vue';
	export default {
		name: 'admin-videos-main',
		components: {Sidebar}
	}
</script>