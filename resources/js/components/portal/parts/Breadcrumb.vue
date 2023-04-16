<template>
        <!-- Start of Breadcrumb -->
        <div class="breadcrumb">
            
                <ul class="list-unstyled">
                    <li><router-link to="/my-courses">Trainings</router-link></li>
                    <li><span>{{ courseName }}</span></li>
                </ul>
            
        </div>
        <!-- End of Breadcrumb -->
</template>
<script>
	 export default {
         name: 'course-breadcrumb',
         props: ['courseName']
	} 
</script>
<style scoped>
.breadcrumb {
    margin-bottom: 20px;
    border-bottom: 0;
}
</style>