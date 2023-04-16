<template>
  <footer id="footer" class="site-footer">
       <div v-if="!isLoggedIn" class="footer-top-area" v-bind:class="{ 'hide' : currentUser == true}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                            <h2 class="footer-title">Subscribe to our newsletter</h2>
                            <p>Sign up with your email address to receive news and updates.</p>
                    </div><!--/.col-lg-9-->
                    <div class="col-lg-5 col-md-6 text-right">
                       <div class="footer-newsletter footer-widget">
                            <div id="mc_embed_signup">
                                <form action="https://synergents.us14.list-manage.com/subscribe/post?u=2b0eae3ea3f41c1d8f6f85b41&amp;id=82971fa9de" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate newsletter-form" target="_blank" novalidate>
                                    <div id="mc_embed_signup_scroll">

                                <div class="form-group">
                                  <input type="email" value="" name="EMAIL" class="required email form-control" id="mce-EMAIL" placeholder="Your Email Address">
                                  <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn btn-default btn-primary">
                                </div>
                                  <div id="mce-responses" class="clear">
                                    <div class="response" id="mce-error-response" style="display:none"></div>
                                    <div class="response" id="mce-success-response" style="display:none"></div>
                                  </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_2b0eae3ea3f41c1d8f6f85b41_82971fa9de" tabindex="-1" value=""></div>
                                    <div class="clear"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!--/.col-lg-3-->
                </div><!--/.row-->
            </div><!--/.container-->
        </div>
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
                                <p>Rahmann St., Cebu City, Philippines</p>

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
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn;
            },
        }
    }
</script>