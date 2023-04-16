<template>
	<section class="page-content  d-padding mentor-area">
		<div id="loader-front" v-if="loading">
 			<div class="loading">
			    <Preloader />
			</div>
 		</div>
		 <div class="container">
		 	<div class="row">
		 		<div class="col-md-12 checkout-section">
		 			<h1>Frequently Asked Questions</h1>
					 <div class="accordion" id="accordionPayment">
						  <div class="card">
						    <div class="card-header" id="headingOne">
						      <h5 class="mb-0">
						        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						          Do I get refunded if I cancel my membership? <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>

						    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionPayment">
						      <div class="card-body">
						        Yes, a full refund will be given to you within the 24 hour period from the timestamp situated at the  payment receipt.

						      </div>
						    </div>
						  </div>
						  <div class="card">
						    <div class="card-header" id="headingTwo">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						          Will you help us find a job after the training is complete? <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionPayment">
						      <div class="card-body">
						        	Spiike has already looked into that in fact a new system is soon to be added as a new feature which will  connect students to employers.
						      </div>
						    </div>
						  </div>
						  <div class="card">
						    <div class="card-header" id="headingThree">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						          Do courses / trainings expire?  <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionPayment">
						      <div class="card-body">
						        Each course/training expiration depends on each course.<br>

						      </div>
						    </div>
						  </div>
						  <div class="card">
						    <div class="card-header" id="headingFour">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">What are your payment methods? <span class="float-right"><font-awesome-icon icon="chevron-down" /></span></button>
						      </h5>
						    </div>
						    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionPayment">
						      <div class="card-body">
							        <p>There are 5 convenient payment methods to pay Spiike you can choose from these options:<br>

            Debit / Credit Card payment, thru PayPal, Palawan Express Pera Padala, 7/11, or from Bank to Bank.</p>

						      </div>
						    </div>
						  </div>
						  <div class="card">
						    <div class="card-header" id="headingFive">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
						          Are you  certified TESDA trainors?  <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionPayment">
							      <div class="card-body">
							        Most of the courses are not available in TESDA, but our trainors have ample experience in digital marketing workting with different clients.<br>
							      </div>
							    </div>
					  		</div>

					  		<div class="card">
						    <div class="card-header" id="headingSix">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
						         How can I get the softwares needed for the training? <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionPayment">
							      <div class="card-body">
							        You can contact our support team for the exact software to necessary to your course. The team will provide the details and guide you into the process.<br>
							      </div>
							    </div>
					  		</div>


					  		<div class="card">
						    <div class="card-header" id="headingSeven">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
						          Why should I choose Spiike?  <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionPayment">
							      <div class="card-body">
							        You should choose Spiike because we are a team of highly skilled individuals dedicated in sharing the core Filipino values and knowledge to everyone. Spiike aims to provide globally competitive Filipinos in the digital world through its quick and easy high quality tutorials. Affordable and efficient tutorials with a class.<br>
							      </div>
							    </div>
					  		</div>


					  		<div class="card">
						    <div class="card-header" id="heading8">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
						          How do I get my certificate? <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordionPayment">
							      <div class="card-body">
							        Once you complete and pass the exam, you can request a certificate of completion for each course.<br>
							      </div>
							    </div>
					  		</div>

					  		<div class="card">
						    <div class="card-header" id="heading9">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
						          How can I make my profile private?  <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapse9" class="collapse" aria-labelledby="heading8" data-parent="#accordionPayment">
							      <div class="card-body">
							        All profiles are currently private. Note: A new feature will be added that will allow you to publicize your achievements and exam results for employement purposes.<br>
							      </div>
							    </div>
					  		</div>

					  		<div class="card">
						    <div class="card-header" id="heading10">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
						          I want to get access to all training and courses.   <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapse10" class="collapse" aria-labelledby="heading8" data-parent="#accordionPayment">
							      <div class="card-body">
							        That option is only possible if you get a VIP membership account. You can contact our support group if you wanted to upgrade or sign up for the VIP account.<br>
							      </div>
							    </div>
					  		</div>

					  		<div class="card">
						    <div class="card-header" id="heading11">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
						          How much do I earn to refer someone? <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordionPayment">
							      <div class="card-body">
							        Please contact our support to give you insights and further details on how our referral system works.<br>
							      </div>
							    </div>
					  		</div>




							<div class="card">
						    <div class="card-header" id="heading12">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
						          The training is not related to my profession, do I have a chance to get hired? <span class="float-right"><font-awesome-icon icon="chevron-down" /></span> 
						        </button>
						      </h5>
						    </div>
						    <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordionPayment">
							      <div class="card-body">
							        Yes you have the chance. Each training is efficiently designed for everyone whether it is a beginner or a professional. Spiike team made sure to develop beginner friendly high quality training materials that will help each student learn faster and become globally competitive. Quick and easy courses that will lead you to the top.<br>
							      </div>
							    </div>
					  		</div>

							<div class="card">
						    <div class="card-header" id="heading12">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
						          How can I access my courses? <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordionPayment">
							      <div class="card-body">
							        It's easy just log in to your account and go to “My Courses“. All information regarding your course/courses are situated there.<br>
							      </div>
							    </div>
					  		</div>

							<div class="card">
						    <div class="card-header" id="heading13">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse13" aria-expanded="false" aria-controls="collapse13">
						          I have accidentally purchase the course / training twice. <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordionPayment">
							      <div class="card-body">
							       You can contact our support team and inform them about the doubled purchase, the team will explain to you the protocols and make the necessary adjustments.<br>
							      </div>
							    </div>
					  		</div>

							<div class="card">
						    <div class="card-header" id="heading14">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse14" aria-expanded="false" aria-controls="collapse14">
						          I am an absolute beginner, I dont know if I can follow.  <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapse14" class="collapse" aria-labelledby="heading14" data-parent="#accordionPayment">
							      <div class="card-body">
							       You don’t have to worry each tutorial is designed to be easy and beginner friendly. Plus our instructors are equipped with the right tools and knowledge to help you reach your top potential and become globally competitive.<br>
							      </div>
							    </div>
					  		</div>

							<div class="card">
						    <div class="card-header" id="heading15">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse15" aria-expanded="false" aria-controls="collapse15">
						          Can I apply my learnings to my business?  <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapse15" class="collapse" aria-labelledby="heading15" data-parent="#accordionPayment">
							      <div class="card-body">
							       Absolutely yes. We have helped numerous business establishments reach success through the utilization of digital marketing. Some of our students were businessmen who wanted to profit more through the help of digital innovations. With the things you have learned with Spiike your business with surely be at the top of the heap.<br>
							      </div>
							    </div>
					  		</div>

					  		<div class="card">
						    <div class="card-header" id="heading16">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse16" aria-expanded="false" aria-controls="collapse16">
						          Can I downgrade my account? <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapse16" class="collapse" aria-labelledby="heading16" data-parent="#accordionPayment">
							      <div class="card-body">
							      Account downgrading is a big NO NO in Spiike. You can opt in for multiple courses purchasing but you cannot downgrade.<br>
							      </div>
							    </div>
					  		</div>


					  		<div class="card">
						    <div class="card-header" id="heading17">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse17" aria-expanded="false" aria-controls="collapse17">
						          I haven’t really used my account, do you think you can give me an extension? <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapse17" class="collapse" aria-labelledby="heading17" data-parent="#accordionPayment">
							      <div class="card-body">
							      Extensions are not allowed as Spiike strives to deliver the latest technologies, strategies and innovations to its customers. Each account is entitled to a maximum of 1 year validity with no extensions. We firmly advised each students to use their account  to reach their full potential and to further avoid regrets along the way.<br>
							      </div>
							    </div>
					  		</div>


					  		<div class="card">
						    <div class="card-header" id="heading17">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse17" aria-expanded="false" aria-controls="collapse17">
						          I am about to add my transaction details, what is the link to add it? <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapse17" class="collapse" aria-labelledby="heading17" data-parent="#accordionPayment">
							      <div class="card-body">
							      This is the link "https://spiike.io/checkout or you can login and add a purchase on your purchase history.For offline payment it will take 24 hours to verify the payment transaction.<br>
							      </div>
							    </div>
					  		</div>


					  		<div class="card">
						    <div class="card-header" id="heading18">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse18" aria-expanded="false" aria-controls="collapse18">
						           Do you issue certification?  <span class="float-right"><font-awesome-icon icon="chevron-down" /></span>
						        </button>
						      </h5>
						    </div>
						    <div id="collapse18" class="collapse" aria-labelledby="heading18" data-parent="#accordionPayment">
							      <div class="card-body">
							      Yes we issue Certificate of Completion but before we give the certificate, you are asked to make a Certificate of Completion or CoC request from your dashboard once you finished your course and then you must pass the evaluation exam to assess your learnings. If you pass the exam the Certificate of Completion will be emailed to you. <br>
							      </div>
							    </div>
					  		</div>

					</div><!-- End of Accordion-->	
		 		</div>
		 	</div>
		 </div>
	</section>
</template>

<script>
	import Preloader from '../loader/Preloader.vue';
	export default {
		name: 'Faqs',
		components: { Preloader },
		data() {
			return {
				loading: true
			}
		},
		mounted() {
			this.loading = false;
		}
	}

</script>
<style scoped>

.checkout-section {
    min-height: 450px;
    background: #fff;
    padding: 20px;
}
.checkout-section h1 {
    font-size: 32px;
    color: #222f3f;
    font-weight: 600;
}
</style>