<template>
    <div>
        <header class="site-header-scrolling">
            <div class="header-top">
                <div class="auto-container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="header-top-info">
                                <span v-if="!isLoggedIn">50% off for Virtual Assistant Training</span>
                                <span v-else>Welcome {{ currentUser.firstname + " "+ currentUser.lastname }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="header-top-navigation">
                                    <template v-if="!isLoggedIn">
                                        <ul class="menu ml-auto list-unstyled">
                                            <li>
                                                <router-link to="/login">Login</router-link>
                                            </li>
                                            <li>
                                                <router-link to="/register">Register</router-link>
                                            </li>
                                        </ul>
                                    </template>
                                    <template v-else>
                                        <ul class="menu user-top-menu ml-auto list-unstyled">
                                            <li>
                                                <div v-if="isAdmin">
                                                    <router-link to="/admin">Dashboard</router-link>
                                                </div>
                                                <div v-else-if="isMentor">
                                                    <router-link to="/mentor">My Profile</router-link>
                                                </div> 
                                                <div v-else>
                                                    <router-link to="/my-profile/dashboard">My Profile</router-link>
                                                </div>    
                                            </li>
                                            <li v-if="!isMentor && !isEmployer">
                                                <router-link to="/my-courses" :key="$route.fullPath">My Courses</router-link>
                                            </li>
                                            <li v-if="isMentor">
                                                <router-link to="/mentor/students" :key="$route.fullPath">My Students</router-link>
                                            </li>
                                            <li v-if="isEmployer">
                                                <router-link to="/my-courses" :key="$route.fullPath">My Jobs</router-link>
                                            </li>
                                            <li class="nav-item dropdown pull-left">
                                                <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
        
                                                    <template v-if="currentUser.image != null">
                                                    <img :src="`/users/${currentUser.image}`" width="24" height="auto" /> <span class="caret"></span>
                                                    </template>
                                                    <template v-else>
                                                    <img :src="'/images/user_image.png'" width="24" height="auto" /> <span class="caret"></span>
                                                    </template>
                                                </a>

                                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                    <ul>
                                                        <li>
                                                            <router-link to="/my-profile/edit">Edit Profile</router-link>
                                                        </li>
                                                        <li>
                                                            <router-link to="/my-profile/change-password">Update Password</router-link>
                                                        </li>
                                                        <li>
                                                            <router-link to="/my-profile/purchases">Purchase History</router-link>
                                                        </li>
                                                        <li><a href="#!" @click.prevent="logout" class="dropdown-item">Logout</a></li>
                                                    </ul>
                                                    
                                                </div>
                                            </li>
                                        </ul>    
                                    </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <nav class="site-navbar">
                <div class="container">
                    <div class="site-navigation__form">
                        <form @submit.prevent="findCourse">
                            <input type="text" v-model="search" v-on:keyup="onPageDown" placeholder="Search...">
                            <button id="closeSearch"><font-awesome-icon icon="times" /></button>
                        </form>
                    </div>
                </div>
            </nav> -->
            <div class="auto-container">
                <nav class="navbar navbar-expand-md navbar-light">
                    <router-link class="navbar-brand" to="/"><img :src="'images/theme/va-logo.png'" width="160" /></router-link>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse site-navigation" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">

                            <template v-if="!isLoggedIn">                      
                                <li class="nav-item active">
                                    <router-link to="/" >Home <span class="sr-only">(current)</span></router-link>
                                </li>
                            </template>
                            <template v-if="isLoggedIn"> 
                                <li class="nav-item active">
                                    <router-link to="/my-profile/dashboard" >My Profile <span class="sr-only">(current)</span></router-link>
                                </li>
                            </template>
                            <template v-if="!isLoggedIn">
                                <li class="nav-item dropdown">
                                    <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Trainings
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown"  v-if="bundleCourses">  
                                        <div class="dropdown-menu-item" v-for="training in bundleCourses" :key="training.id">
                                            <router-link  :to="`/trainings/${training.id}`" class="dropdown-item">{{training.display_name}}</router-link>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/about" >About</router-link>
                                </li> 
                                <li class="nav-item">
                                    <router-link to="/faqs" >Faqs</router-link>
                                </li>
                                
                                <li class="nav-item">
                                    <router-link to="/contact" >Contact Us</router-link>
                                </li>
                            </template>
                            <template v-if="isLoggedIn">
                                <li class="nav-item">
                                    <router-link to="/my-courses" >My Trainings</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/mentors" >Mentors</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/webinars" >Webinars</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/resources" >Resources</router-link>
                                </li>
                                <!-- <li class="nav-item">
                                    <router-link to="/support" >Support</router-link>
                                </li> -->
                            </template>    
                                
                        </ul>
                    </div>
                </nav>
            </div>    
            <!-- Start of site header bottom -->
            <div class="site-header-bottom">
                <div class="search-courses-area" v-if="courses.length">
                    <div class="container"> 
                        <div class="search-inner">
                            <div class="search-item" v-for="course in courses" :key="course.id">
                                <h4><router-link :to="`/courses/${course.id}`">{{ course.title }}</router-link></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of site header bottom -->
        </header> 
        <header class="site-header">
            <div class="header-top">
                <div class="auto-container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="header-top-info">
                                <span v-if="!isLoggedIn">50% off for Virtual Assistant Training</span>
                                <span v-else>Welcome {{ currentUser.firstname + " "+ currentUser.lastname }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="header-top-navigation">
                                    <template v-if="!isLoggedIn">
                                        <ul class="menu ml-auto list-unstyled">
                                            <li>
                                                <router-link to="/login">Login</router-link>
                                            </li>
                                            <li>
                                                <router-link to="/register">Register</router-link>
                                            </li>
                                        </ul>
                                    </template>
                                    <template v-else>
                                        <ul class="menu user-top-menu ml-auto list-unstyled">
                                            <li>
                                                <div v-if="isAdmin">
                                                    <router-link to="/admin">Dashboard</router-link>
                                                </div>
                                                <div v-else-if="isMentor">
                                                    <router-link to="/mentor">My Profile</router-link>
                                                </div> 
                                                <div v-else>
                                                    <router-link to="/my-profile/dashboard">My Profile</router-link>
                                                </div>    
                                            </li>
                                            <li v-if="!isMentor && !isEmployer">
                                                <router-link to="/my-courses" :key="$route.fullPath">My Courses</router-link>
                                            </li>
                                            <li v-if="isMentor">
                                                <router-link to="/mentor/students" :key="$route.fullPath">My Students</router-link>
                                            </li>
                                            <li v-if="isEmployer">
                                                <router-link to="/my-courses" :key="$route.fullPath">My Jobs</router-link>
                                            </li>
                                            <li class="nav-item dropdown pull-left">
                                                <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
        
                                                    <template v-if="currentUser.image != null">
                                                    <img :src="`/users/${currentUser.image}`" width="24" height="auto" /> <span class="caret"></span>
                                                    </template>
                                                    <template v-else>
                                                    <img :src="'/images/user_image.png'" width="24" height="auto" /> <span class="caret"></span>
                                                    </template>
                                                </a>

                                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                    <ul>
                                                        <li>
                                                            <router-link to="/my-profile/edit">Edit Profile</router-link>
                                                        </li>
                                                        <li>
                                                            <router-link to="/my-profile/change-password">Update Password</router-link>
                                                        </li>
                                                        <li>
                                                            <router-link to="/my-profile/purchases">Purchase History</router-link>
                                                        </li>
                                                        <li><a href="#!" @click.prevent="logout" class="dropdown-item">Logout</a></li>
                                                    </ul>
                                                    
                                                </div>
                                            </li>
                                        </ul>    
                                    </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <nav class="site-navbar">
                <div class="container">
                    <div class="site-navigation__form">
                        <form @submit.prevent="findCourse">
                            <input type="text" v-model="search" v-on:keyup="onPageDown" placeholder="Search...">
                            <button id="closeSearch"><font-awesome-icon icon="times" /></button>
                        </form>
                    </div>
                </div>
            </nav> -->
            <div class="auto-container">
                <nav class="navbar navbar-expand-md navbar-light">
                    <router-link class="navbar-brand" to="/"><img :src="'images/theme/va-logo.png'" width="160" /></router-link>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse site-navigation" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">

                            <template v-if="!isLoggedIn">                      
                                <li class="nav-item active">
                                    <router-link to="/" >Home <span class="sr-only">(current)</span></router-link>
                                </li>
                            </template>
                            <template v-if="isLoggedIn"> 
                                <li class="nav-item active">
                                    <router-link to="/my-profile/dashboard" >My Profile <span class="sr-only">(current)</span></router-link>
                                </li>
                            </template>
                            <template v-if="!isLoggedIn">
                                <li class="nav-item dropdown">
                                    <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Trainings
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown"  v-if="bundleCourses">  
                                        <div class="dropdown-menu-item" v-for="training in bundleCourses" :key="training.id">
                                            <router-link  :to="`/trainings/${training.id}`" class="dropdown-item">{{training.display_name}}</router-link>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/about" >About</router-link>
                                </li> 
                                <li class="nav-item">
                                    <router-link to="/faqs" >Faqs</router-link>
                                </li>
                                
                                <li class="nav-item">
                                    <router-link to="/contact" >Contact Us</router-link>
                                </li>
                            </template>
                            <template v-if="isLoggedIn">
                                <li class="nav-item">
                                    <router-link to="/my-courses" >My Trainings</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/mentors" >Mentors</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/webinars" >Webinars</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/resources" >Resources</router-link>
                                </li>
                                <!-- <li class="nav-item">
                                    <router-link to="/support" >Support</router-link>
                                </li> -->
                            </template>    
                                
                        </ul>
                    </div>
                </nav>
            </div>    
            <!-- Start of site header bottom -->
            <div class="site-header-bottom">
                <div class="search-courses-area" v-if="courses.length">
                    <div class="container"> 
                        <div class="search-inner">
                            <div class="search-item" v-for="course in courses" :key="course.id">
                                <h4><router-link :to="`/courses/${course.id}`">{{ course.title }}</router-link></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of site header bottom -->
        </header>   
    </div>

</template>

<script>
    import JQuery from 'jquery';
    import { mapGetters, mapActions } from 'vuex';
    export default {
        name: 'app-header',
        data() {
            return  {
                search: '',
                courses: [],
                carts: [],
                cartadd: {
                    id: '',
                    name: '',
                    price: '',
                    amount: ''
                } ,
                badge: '0', 
                quantity: '1',
                totalprice: '0',
                singleBundle: false,
                bundleCourses: {}
            }
        },
        computed: {
            currentUser() {
               if(!this.$store.getters.currentUser && this.isLoggedIn ) {
                return null;
               }
                return this.$store.getters.currentUser;
            },
            isAdmin() {
                return this.currentUser.role == 1 ? true: false;
            },
            isMentor() {
                return this.currentUser.role == 8 ? true: false;
            },
            isEmployer() {
                return this.currentUser.role == 9 ? true: false;
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn;
            },
            inCart() {
                return this.$store.getters.inCart
            }
        },
        mounted() {

            this.getAllBundleCourses();

            let $ = JQuery;

            $('#searchBtn').on('click', function(){
                $('.site-navigation__form').addClass('show');
                if( $('.search-courses-area').hasClass('hide') ) {
                    $('.search-courses-area').removeClass('hide');
                }
            });

            $('#closeSearch').on('click', function(){
                $('.search-courses-area').addClass('hide');
                $('.site-navigation__form').removeClass('show');
                $('.site-navigation__form input[type="text"]').val('');
                $('.site-header-bottom').html();
            });

            $('.mobile-menu').on('click', function(){
                $('.mobile-nav').slideToggle();
            });

            $('.mobile-nav a').on('click', function(){
                $('.mobile-nav').slideToggle();
            });

            let lastScrollPos = 0;

            function fixedMenu() {
                let newScrollPos = window.scrollY;

                    if (newScrollPos < lastScrollPos) {
                        // Going 3
                        if ($(window).scrollTop() < 200) {
                            $('.site-header-scrolling').addClass('hiding');
                        }

                        // if ($(window).scrollTop() < 200) {
                        //     $('.site-header-scrolling').removeClass('hiding');
                        // }
                    } 
                    else {// Going Down
                    }

                lastScrollPos = newScrollPos;

                if ($(window).scrollTop() > 250) {
                    $('.site-header-scrolling').addClass('fixed');
                } else {
                    $('.site-header-scrolling').removeClass('fixed'); 
                    $('.site-header-scrolling').removeClass('hiding');
                }
            }

            $(window).scroll(fixedMenu);


        },
        methods: {
            getAllBundleCourses() {
                axios.get(`/api/bundle-courses-list`)
                    .then((response) => {
                        
                        this.bundleCourses = response.data.access_levels;


                    })
                    .catch((error) => {
                        console.log(error);
                        this.error = error.message;
                })
			},
            logout() {
                this.$store.commit('logout');
                this.$router.push('/login');
            },
            onPageDown: function(event) {
          
                if(!this.$data.search.length || this.$data.search.length == 1) {
                    this.courses = '';
                    return;
                }

                axios.post('/api/search', {
                        search: this.$data.search
                    })
                     .then((response) => {
         
                         this.courses = response.data.courses.data;
                     })
                     .catch((error) => {
                        console.log(error);
                     })
            },
            findCourse() {
                this.courses = '';
            },
            ...mapActions(["getInCart"])
        }
    }      

</script>

<style scoped>
	.container {
	    padding: 0 15px;
	}
    .dropdown-menu li {
        display: block;
        width: 100%;
        text-align: right;
        margin: 0 !important;
    }
    .dropdown-menu li a { 
        padding: 5px 7px;
        display: block;
    }
    .navbar {
       padding: 1rem 0;
    }
    .site-navigation ul li .dropdown-menu-item a {
        padding: 6px 10px 2px !important;
        display: block;
        text-transform: capitalize !important;
        font-size: 16px;
        font-weight: 500;
    }
    .site-navigation ul li .dropdown-menu-item a:focus {
        background:#062b48;
    }
    .dropdown-menu.show {
        padding: 0;
    }
</style>