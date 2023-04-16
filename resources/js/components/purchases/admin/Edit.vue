<template>
	<div class="container">
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
				<label for="name"><strong>Student</strong></label>
				<select id="student"  v-model="purchase.user_id">
					<option value="">Select student</option>	
					<option  v-for="student in students" v-bind:value="student.id" :key="student.id" >{{ student.firstname }} {{ student.lastname }}</option>
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
				<label for="name"><strong>Status</strong></label>
				<select id="status" v-model="purchase.status">
					<option value="">Select status</option>
					<option value="pending">Payment is Pending</option>
					<option value="approved">Payment is Approved</option>
				</select>
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
</template>
<script>
	import validate from 'validate.js';
	import { VueEditor } from 'vue2-editor';
	export default {
		name: 'new',
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
				message: '',
				access_id: ''
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
		
			this.getStudents();
			this.getPurchase();
		},
		methods: {
			getPurchase() {
				axios.get(`/api/purchases/${this.$route.params.id}`)
					 .then((response) => {
					 
				  		  this.purchase = response.data.purchase;
						  this.user = response.data.purchase.user;
						  this.training = response.data.purchase.access;
						  this.selectedPricing = response.data.purchase.amount;
						  this.access_id = response.data.purchase.access_id;
					 })
			},
			add() {

				this.errors = null;
				const constraints = this.getConstraints();
				const errors = validate(this.$data.purchase, constraints)

				if(errors) {
					this.errors = errors;
					return;
				}

				axios.post(`/api/purchases/update/${this.$route.params.id}`,  {
						'access_id' :  this.access_id,
						'amount' : this.selectedPricing,
						'user_id' : this.purchase.user_id,
						'status' : this.purchase.status,
						'payment_method' : this.purchase.payment_method,
						'notes' : this.purchase.notes
			
				},  {
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
			getStudents() {
				axios.get('/api/students-list', {
					  headers: {
					  	 "Authorization" : `Bearer ${this.currentUser.token}`
					  }
					})
					.then(response => {
						this.students = response.data.students;
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