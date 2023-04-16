<template>
    <div class="home-content page-content d-padding">

		<div class="auto-container">

			<div class="row">
				<div class="col-lg-2 col-md-12">
					
					<Sidebar/>

				</div>
				<div class="col-lg-10 col-md-12">
					
					<!-- Start of Home Main Content -->
					<div class="home-dashboard">
						<div class="card">
							<div class="card-body">
								<router-view></router-view>	
							</div>
						</div>
					</div>
					<!-- End of Home Main Content -->
					<ul class="list-unstyled helpful-links">
						<li><router-link to="/privacy-policy">Privacy Policy</router-link></li>
						<li><router-link to="/terms-conditions">Terms and Conditions</router-link></li>
					</ul>
					<span class="copyright-footer">© 2020 Virtual Academy PH</span>
					
				</div>
			</div>
		</div>
    </div>
</template>

<script>
	import Sidebar from './home/Sidebar.vue';

	export default {
		name: 'home',
		components: {Sidebar}
	}

</script>
<style scoped>
	.copyright-footer {
		text-align: right;
		display: block;
		color: #ababbd;
		font-size: 14px;
	}
	.helpful-links {
		margin-top: 20px;
		margin-bottom: 0;
		text-align: right;
	}
	.helpful-links li {
		display: inline-block;
		margin-left: 7px;
	}
	.helpful-links li a {
		color: #222;
	}
</style>