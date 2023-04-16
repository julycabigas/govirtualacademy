<template>
	<aside class="sidebar home-sidebar">
		 <div class="widget widget-home-nav">
		 	 <ul class="list-unstyled">
		 	 	<li >
		 	 		<div class="nav-no-parent">
		 	 			<router-link to="/admin/"><strong><i><font-awesome-icon icon="home" /></i> Dashboard</strong>	</router-link>
		 	 		</div>
		 	 	</li>
		 	 	<li  v-on:click="openSubmenu">
		 	 		<div class="top-nav-title">
		 	 			<strong><i><font-awesome-icon icon="id-badge" /></i> Training <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></strong>
		 	 			<ul class="sub-menu">
							<li><router-link to="/admin/training">All Training</router-link></li>
							<li><router-link to="/admin/training/new">New Training</router-link></li>
						</ul>	
		 	 		</div>
		 	 	</li>
		 	 	<li v-on:click="openSubmenu">
		 	 		<div class="top-nav-title">
		 	 			<strong><i><font-awesome-icon icon="graduation-cap" /></i> Courses <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></strong>
		 	 			<ul class="sub-menu">
							<li><router-link to="/admin/courses">All Courses</router-link></li>
							<li><router-link to="/admin/courses/new">New Course</router-link></li>
							<li><router-link to="/admin/categories">Categories</router-link></li>
							<li><router-link to="/admin/courses-group/new">Add Course Group</router-link></li>
						</ul>	
		 	 		</div>
		 	 	</li>
				<li  v-on:click="openSubmenu">
		 	 		<div class="top-nav-title">
		 	 			<strong><i><font-awesome-icon icon="play" /></i> Lectures <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></strong>
		 	 			<ul class="sub-menu">
							<li><router-link to="/admin/videos">All lectures</router-link></li>
							<li><router-link to="/admin/videos/new">New lecture</router-link></li>
						</ul>	
		 	 		</div>
		 	 	</li>
				  <li v-on:click="openSubmenu">
		 	 		<div class="top-nav-title">
		 	 			<strong><i><font-awesome-icon icon="star"  /></i> Groups & Steps <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></strong>
		 	 			<ul class="sub-menu">
							<li><router-link to="/admin/courses-group">All  Trainings</router-link></li>
							<li><router-link to="/admin/courses-group/create">New Training</router-link></li>
							<li><router-link to="/admin/all-groups">All Courses</router-link></li>
							<li><router-link to="/admin/courses-group/new">Add Course to Training</router-link></li>
						</ul>	
		 	 		</div>
		 	 	</li>
				<li v-on:click="openSubmenu">
		 	 		<div class="top-nav-title">
		 	 			<strong><i><font-awesome-icon icon="address-book"  /></i> Tasks <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></strong>
		 	 			<ul class="sub-menu">
							<li><router-link to="/admin/tasks">All Tasks</router-link></li>
							<li><router-link to="/admin/tasks/create">New Task</router-link></li>
							<li><router-link to="/admin/tasks/new">Complete Task</router-link></li>
							<li><router-link to="/admin/tasks/student-list">All Completed</router-link></li>
						</ul>	
		 	 		</div>
		 	 	</li>
				<li v-on:click="openSubmenu">
		 	 		<div class="top-nav-title">
		 	 			<strong><i><font-awesome-icon icon="address-book"  /></i> Resources <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></strong>
		 	 			<ul class="sub-menu">
							<li><router-link to="/admin/resources">All Resources</router-link></li>
							<li><router-link to="/admin/resources/create">New Item</router-link></li>
							<li><router-link to="/admin/resources/new">New Category</router-link></li>
							<li><router-link to="/admin/resources/cat-list">All Categories</router-link></li>
						</ul>	
		 	 		</div>
		 	 	</li>
				  <li v-on:click="openSubmenu">
		 	 		<div class="top-nav-title">
		 	 			<strong><i><font-awesome-icon icon="address-book"  /></i> Webinars <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></strong>
		 	 			<ul class="sub-menu">
							<li><router-link to="/admin/webinars">All Webinars</router-link></li>
							<li><router-link to="/admin/webinars/create">New Item</router-link></li>
						</ul>	
		 	 		</div>
		 	 	</li>
				<li v-on:click="openSubmenu">
		 	 		<div class="top-nav-title">
		 	 			<strong><i><font-awesome-icon icon="address-book"  /></i> Badges <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></strong>
		 	 			<ul class="sub-menu">
							<li><router-link to="/admin/badges">All Badges</router-link></li>
							<li><router-link to="/admin/badges/create">New Badge</router-link></li>
							<li><router-link to="/admin/badges/new">Add Student's Badge</router-link></li>
							<li><router-link to="/admin/badges/student-list">All Student Badges</router-link></li>
						</ul>	
		 	 		</div>
		 	 	</li>
		 	 	<li  v-on:click="openSubmenu">
		 	 		<div class="top-nav-title">
		 	 			<strong><i><font-awesome-icon icon="id-badge" /></i> Purchases <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></strong>
		 	 			<ul class="sub-menu">
							<li><router-link to="/admin/purchases">All Purchases</router-link></li>
							<li><router-link to="/admin/pending-purchases">Pending Orders</router-link></li>
							<li><router-link to="/admin/purchases/new">New Purchase</router-link></li>
						</ul>	
		 	 		</div>
		 	 	</li>
		 	 	<li  v-on:click="openSubmenu">
		 	 		<div class="top-nav-title">
		 	 			<strong><i><font-awesome-icon icon="users" /></i> Students <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></strong>
		 	 			<ul class="sub-menu">
							<li><router-link to="/admin/students">All Students</router-link></li>
							<li><router-link to="/admin/students/new">New Student</router-link></li>
						</ul>	
		 	 		</div>
		 	 	</li>
				<li v-on:click="openSubmenu">
		 	 		<div class="top-nav-title">
		 	 			<strong><i><font-awesome-icon icon="address-book"  /></i> Exercises <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></strong>
		 	 			<ul class="sub-menu">
							<li><router-link to="/admin/exercises">All Exercises</router-link></li>
							<li><router-link to="/admin/exercises/create">New Exercise</router-link></li>
							<li><router-link to="/admin/exercises/listing">All Student List</router-link></li>
						</ul>	
		 	 		</div>
		 	 	</li>  
				  <li  v-on:click="openSubmenu">
		 	 		<div class="top-nav-title">
		 	 			<strong><i><font-awesome-icon icon="users" /></i> Mentors <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></strong>
		 	 			<ul class="sub-menu">
							<li><router-link to="/admin/mentors">All Mentors</router-link></li>
						</ul>	
		 	 		</div>
		 	 	</li>
		 	 	<li  v-on:click="openSubmenu">
		 	 		<div class="top-nav-title">
		 	 			<strong><i><font-awesome-icon icon="star" /></i> Examination <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></strong>
		 	 			<ul class="sub-menu">
							<li><router-link to="/admin/examination">All Examinations</router-link></li>
							<li><router-link to="/admin/examination/new">New Examination</router-link></li>
						</ul>	
		 	 		</div>
		 	 	</li>
		 	 	<li  v-on:click="openSubmenu">
		 	 		<div class="top-nav-title">
		 	 			<strong><i><font-awesome-icon icon="certificate" /></i> Certification <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></strong>
		 	 			<ul class="sub-menu">
							<li><router-link to="/admin/certificates">All Certification</router-link></li>
							<li><router-link to="/admin/certificates-request">All Request</router-link></li>
						</ul>	
		 	 		</div>
		 	 	</li>
		 	 	<li  v-on:click="openSubmenu">
		 	 		<div class="top-nav-title">
		 	 			<strong><i><font-awesome-icon icon="address-book" /></i> Reviews <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></strong>
		 	 			<ul class="sub-menu">
							<li><router-link to="/admin/reviews">All Reviews</router-link></li>
							<li><router-link to="/admin/reviews/create">New Review</router-link></li>
						</ul>	
		 	 		</div>
		 	 	</li>
		 	 	<li  v-on:click="openSubmenu">
		 	 		<div class="top-nav-title">
		 	 			<strong><i><font-awesome-icon icon="clipboard" /></i> Posts <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></strong>
		 	 			<ul class="sub-menu">
							<li><router-link to="/admin/posts">All Posts</router-link></li>
							<li><router-link to="/admin/posts/new">New Post</router-link></li>
						</ul>	
		 	 		</div>
		 	 	</li>
		 	 	<li><div class="nav-no-parent"><router-link to="/admin/settings"><strong><i><font-awesome-icon icon="cogs" /></i> Settings</strong></router-link></div></li>
		 	 </ul>
		 </div>
	</aside>
</template>
<script>
	 export default {
	 	name: 'sidebar',
	 	methods: {
           	 openSubmenu: function(event) {

           	 		//Toggle Dropdown
           	 		if(event.path[1].classList[1] == 'active') {
           	 			
           	 			event.path[1].classList.remove('active');
           	 		} else {
           	 			event.path[1].className += " active";
           	 		}
 
           	 	
           	 }
	 	}
	}
</script>
<style>
	.top-nav-title strong,
	.nav-no-parent a {
		padding: 10px 10px 5px 0;
		display: block;
		color: #222f3f;
		font-weight: 600;
	}
	.top-nav-title:hover {
		background: transparent;
		cursor: pointer;
	}
	.top-nav-title strong > span {
        font-size: 10px;
        color: #e1e1e4;
	}
	.sub-menu {
		display: none;
		list-style: none;
		padding: 0;
	}
	.active  .sub-menu {
		display: block;
	}
</style>