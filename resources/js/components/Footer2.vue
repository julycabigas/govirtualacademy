<template>
  <footer id="footer" class="site-footer">
       <div class="footer-widgets-area">
           <div class="container">
               <div class="row">
                    <div class="col-sm-12">
                      <span class="spacing"></span>
                    </div>  
                    <div class="col-md-3 col-sm-12">

                        <div class="footer-widget">
                            <h4 class="footer-title">Main Menu</h4>
                            <ul class="footer-widget-list list-unstyled">
                                <li><router-link to="/trainings">Trainings</router-link></li>
                                <li><router-link to="/about">About Us</router-link></li>
                                <li><router-link to="/testimonials">Reviews</router-link></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="footer-widget">
                            <h4 class="footer-title">Legal & Info</h4>
                            <ul class="footer-widget-list list-unstyled">
                                <li><router-link to="/terms-conditions">Terms and Conditions</router-link></li>
                                <li><router-link to="/privacy-policy">Privacy Policy</router-link></li>
                                <li><router-link to="/contact">Contact Us</router-link></li>
                                <li><router-link to="/faqs">FAQs</router-link></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="footer-widget">

                            <h4 class="footer-title">Get Started</h4>
                            <ul class="footer-widget-list list-unstyled">
                                <li><router-link to="/register">Sign up</router-link></li>
                                <li><router-link to="/login">Login</router-link></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 offset-md-1 col-sm-12">

                        <div class="footer-widget-contact">
                                <p>Rahmann St. Barangay Zapatera, <br>6000 Cebu City, Philippines</p>

                                <p>Phone PH: +63 923 173 6505<br>
                                Email: support@virtualacademy.ph</p>
                        </div>

                        <ul class="footer-widget-social list-unstyled">
                            <li><a class="navbar-brand" href="https://www.facebook.com/virtualacademyph" target="_blank"><img :src="'/images/theme/facebook-logov2.svg'" width="100%" /></a></li>
                            <!-- <li><a class="navbar-brand" href="https://www.facebook.com/spiike.io"><img :src="'/images/theme/linkedin-logo.svg'" width="100%" /></a></li>
                            <li><a class="navbar-brand" href="https://www.facebook.com/spiike.io"><img :src="'/images/theme/twitter-social-logo.svg'" width="100%" /></router-link></li> -->
                        </ul>

                    </div>

                       

                 

               </div>
           </div>
       </div>
       <!-- Start footer copyright area -->
        <div class="footer-copyright-area bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="copyright">
                           All right reserved 2019 © Copyrighted by Virtual Academy PH.
                        </div>
                    </div>
                </div><!--/.row-->
            </div><!--/.container-->
        </div>
       <!-- End footer copyright area -->
  </footer>

</template>

<script>
    export default {
        name: 'app-footer',
        computed: {
            currentUser() {
                   if(!this.$store.getters.currentUser && this.isLoggedIn ) {
                    return null;
                   }
                    return this.$store.getters.currentUser;
            }
        }
    }
</script>