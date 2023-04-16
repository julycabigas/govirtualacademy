<template>

    <header class="site-header site-header-v2">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="header-top-info">
                            <span>50% off for Virtual Assistant Training</span>
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
                                                <a href="#!" @click.prevent="logout" class="dropdown-item">Logout</a>
                                            </div>
                                        </li>
                                    </ul>    
                                </template>
                         </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="site-navbar">
            <div class="container">
                <div class="site-navigation__form">
                    <form @submit.prevent="findCourse">
                        <input type="text" v-model="search" v-on:keyup="onPageDown" placeholder="Search...">
                        <button id="closeSearch"><font-awesome-icon icon="times" /></button>
                    </form>
                </div>
                <div class="grid">
                    <div class="site-logo">
                       <router-link class="navbar-brand" to="/"><img :src="'images/theme/va-logo.png'" width="100%" /></router-link>
                    </div>
                    <div class="site-navigation">
                            <div class="mobile-menu">
                                <button>
                                    <img :src="'images/theme/open-menu.svg'" width="100%" />
                                </button>
                            </div>
                            <div class="inner-nav">
 
                             
                            </div>
                    </div>
                    <div class="mobile-nav">
                        <div class="inner-nav">
                                
                            </div>
                    </div>
                </div>
            </div>
        </nav>
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
                totalprice: '0'
            }
        },
        methods: {
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

            // if(localStorage.getItem('inCart')) {
            //         this.carts = JSON.parse(localStorage.getItem('inCart'));
            //         this.inCart = this.carts.length;
                   
            // } else {
            //     this.inCart = 0;
            // }

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

        },
    }      

</script>

<style scoped>
	.container {
	    padding: 0 15px;
	}
</style>