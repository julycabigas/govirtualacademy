<template>
	<div class="cart-area">
		<div class="container pt-4">
			<h1 class="pt-4 font-weight-bold">Your Cart</h1>
			<div class="row">
				<div class="col-md-12" v-if="carts.length">
						<div class="content-body">
							<table class="table table-striped text-left">
				 				<tbody>
				 					<tr>
				 						<th>Name</th>
				 						<th>Price</th>
				 						<th>Action</th>
				 					</tr>
				 					<tr v-for="(cart, n) in inCart" key="cart.name">
				 						<td>{{ cart.name}}</td>
				 						<td>Php {{ cart.price}}</td>
				 						<td width="60">
				 							<button @click="removeCart()" class="btn btn-danger btn-sm">Remove</button>
				 						</td>
				 					</tr>
				 				</tbody>
				 			</table>
						</div>
						<div class="content-footer text-right font-weight-bold">
							<strong class="grandtotal">Total Price: Php {{ totalprice}}</strong> 
						</div>
				</div>
				<div class="col-md-12" v-else>
					<p>Cart is empty. Please purchase the course you want.</p>	
				</div>
				<div class="col-md-12 text-right pt-5">
					<router-link to="/courses" class="btn btn-secondary">Continue Shopping</router-link>
					<router-link to="/checkout" class="btn btn-primary" v-if="carts.length">Proceed to Checkout</router-link>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import PayPal from 'vue-paypal-checkout';
	import { mapActions } from 'vuex';

	export default {
		name: 'checkout',
		components: {
		    PayPal
		},
		data() {
			return {
				carts: [],
				cartadd: {
					id: '',
					name: '',
					price: '',
					amount: ''
				},
				total: '0',
				badge: '0', 
				quantity: '1',
				totalprice: '2',
				credentials: {
			        sandbox: 'AW3YIXr1OYy53L-G63I117vIWEcKQxuUoyMtuhm-yEvPNjniunTCnkrEIQoiuOhkOMkoFjaUPj-Cjidh',
			        production: 'AW3YIXr1OYy53L-G63I117vIWEcKQxuUoyMtuhm-yEvPNjniunTCnkrEIQoiuOhkOMkoFjaUPj-Cjidh'
			    },
			    status: '',
			    amount: '',
			    user_id: '',
			    payment_method: '',
			    user: {
					email: '',
					password: '',
					province: '',
					city: '',
					zipcode: '',
					address: '',
					firstname: '',
					lastname: '',
					role: 6,
					phone: ''
				},
				provinces : [
				 'Abra','Agusan','Aklan','Albay','Antique','Apayao','Aurora',
				 'Basilan','Bataan','Batanes','Batangas','Benguet','Biliran','Bohol','Bukidnon','Bulacan',
				 'Cagayan','Camarines','Camiguin','Capiz','Catanduanes','Cavite','Cebu','Compostela Valley','Cotabato',
				 'Davao','Dinagat Islands','Guimaras','Ifugao','Ilocos','Iloilo','Isabela',
				 'La Union', 'Laguna','Lanao','Leyte','Maguindanao','Marinduque','Mindoro','Misamis','Mountain Province',
				 'Negros','Nueve Ecija','Nueva Vizcaya','Palawan','Pampanga','Pangasinan',
				 'Quezon','Quirino','Rizal','Romblon','Samar','Sarangani','Sibugay','Siquijor','Sorsogon','Sultan Kudarat',
				 'Sulu','Surigao','Tarlac','Tawi-Tawi','Zambales','Zamboanga'
				 ],
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			inCart() {
                return this.$store.getters.inCart
            }
		},
		mounted() {
			this.viewCart();
		},
		methods: {
			...mapActions(['removeInCart']),
			viewCart(){
				// if(localStorage.getItem('inCart')) {
				// 	this.carts = JSON.parse(localStorage.getItem('inCart'));
				// 	this.badge = this.carts.length;
				// 	this.totalprice = this.carts.reduce((total, item) => {
				// 		return total + this.quantity  * item.price;
				// 	}, 0) 

				// }
				this.carts = this.inCart;
				this.totalprice = this.carts.reduce((total, item) => {
					return total + this.quantity  * item.price;
				}, 0); 
			},
			paymentAuthorized: function (data) {
	          console.log(data);
	        },
	        paymentCompleted: function (data) {
		          console.log(data);
		          localStorage.removeItem('carts');
		          this.carts = '';

		          //console.log(this.currentUser.id);
		     	  //console.log(data['transactions'][0]);
		          //console.log(data['transactions'][0]['amount']);


		          this.status = data['state'];
		          
		          console.log(this.currentUser);
		          axios.post('/api/purchases/new', {
		          		     	'user_id' : this.currentUser.id,
								'status'  : this.status, 
								'amount'  : this.totalprice,
								'payment_method': 'paypal'

		          		}, {
						  headers: {
						  	 "Authorization" : `Bearer ${this.currentUser.token}`
						  }
						})
						.then((response) => {
							alert('Successful purchased!');
						})
						.catch((error) => {
							console.log(error);
						});
	        },
	        paymentCancelled: function (data) {
	          console.log(data);
	        },
	        removeCart(pro) {
				this.carts.splice(pro, 1);
				this.storeCart();
				this.inCart = false;
			},
			storeCart() {
				let parsed = JSON.stringify(this.carts);
				localStorage.setItem('inCart', parsed);
				this.$store.dispatch('removeInCart', this.carts);
				this.viewCart();
			}
		},
	
	}
</script>
<style scoped>
.grandtotal {
	font-size: 18px;
    color: #222f3f;
    display: block;
    padding: 5px 10px;
    background: #f3f6f9;
    border-top: 1px solid #edeff1;
}
.cart-area {
    margin-bottom: 50px;
}
</style>