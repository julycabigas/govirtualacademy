<template>
	<div class="container">
		<!-- Start of Breadcrumb -->
		<div class="breadcrumb mt-5 mb-3">
	
				<ul class="list-unstyled">
					<li><router-link to="/my-profile/dashboard">My Profile</router-link></li>
					<li><span>Add Purchase</span></li>
				</ul>
			
		</div>
		<!-- End of Breadcrumb -->
		<div class="card card-body">
				<form @submit.prevent="add">
					<div class="message alert alert-success" v-if="message">{{ message }}</div>
					<div class="form-group">
						<label for="name"><strong>Payment Method</strong></label>
						<select id="status" v-model="purchase.payment_method">
							<option value="">Select payment method</option>
							<option value="Paypal">Paypal</option>
							<option value="Paymaya">Paymaya</option>
							<option value="Gcash">Gcash</option>
							<option value="Palawan Express">Palawan Express</option>
							<option value="ML Kwarta Padala">ML Kwarta Padala</option>
							<option value="BPI">BPI</option>
							<option value="BDO">BDO</option>
							<option value="Credit Card">Credit Card</option>
						</select>
					</div>


					<div class="form-group">
						<label for="name"><strong>Training</strong></label>
						<select id="training" v-model="purchase.access_id" @change="changePricing">
							<option value="">Select Training</option>
							<option  v-for="training in trainings" v-bind:value="training" :key="training.id">{{ training.display_name }}</option>
						</select>
					</div>	
					<div class="form-group">
						<label for="name"><strong>Amount (Php)</strong></label>
						<input type="number" name="amount" v-model="selectedPricing" />
					</div>
					<div class="form-group">
						<label for="description"><strong>Notes</strong></label>
						<vue-editor  v-model="purchase.notes"></vue-editor>
					</div>

					<input type="submit" value="Purchase" class="btn btn-primary">

					<div class="errors" v-if="errors">
						<ul>
							<li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
								<strong>{{ fieldName }}</strong> {{ fieldsError.join('\n') }}
							</li>
						</ul>
					</div>
				</form>			
		</div>
	</div>
</template>
<script>
	import validate from 'validate.js';
	import { VueEditor } from 'vue2-editor';
	export default {
		name: 'add-purchase',
		components: {
			VueEditor
		},
		data() {
			return {
				purchase: {
					amount: '',
					status: '',
					payment_method: '',
					user_id: '',
					training: '',
					access_id: '',
					notes: ''
				},
				trainings: {},
				students: {},
				errors: null,
				amount: '',
				selectedPricing: '',
				message: ''
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			}
		},
		mounted() {
		
			axios.get('/api/access-list', {
				  headers: {
				  	 "Authorization" : `Bearer ${this.currentUser.token}`
				  }
				})
				.then(response => {
					this.trainings = response.data.access_levels;
				});
		
		},
		methods: {
			add() {

				this.errors = null;
				const constraints = this.getConstraints();
				const errors = validate(this.$data.purchase, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}

				axios.post('/api/purchases/new',  {
						'access_id' :  this.access_id,
						'amount' : this.selectedPricing,
						'user_id' : this.currentUser.id,
						'status' : 'pending',
						'payment_method' : this.purchase.payment_method,
						'notes' : this.purchase.notes
					},{
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					.then((response) => {
						this.message = response.data.message;
						this.purchase = {};
					})
					.catch((error) => {
						console.log(error);
					});

			},
			changePricing() {
		
				this.selectedPricing = this.purchase.access_id.discount_price;
				
				this.access_id = this.purchase.access_id.id;

			},
			getConstraints() 
			{
				return  {
					payment_method: {
                        presence: true, 
						length: {
							minimum: 2,
							message: 'Must be at least 5 characters long'
						}
					}
				}
			}
		}
	}
</script>
<style scoped>
.card {
	background: transparent;
}
</style>