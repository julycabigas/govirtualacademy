require('./bootstrap');

import vueVimeoPlayer from 'vue-vimeo-player'
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import {routes} from './routes';
import storeData from './store';
import MainApp from './components/MainApp.vue';
import { initialize } from './helpers/general';
import { ToggleButton } from 'vue-js-toggle-button';
import StarRating from 'vue-star-rating';
import VueCurrencyFilter from 'vue-currency-filter'
import createPersistedState from 'vuex-persistedstate'

import { library } from '@fortawesome/fontawesome-svg-core'
import { faPlay, 
	     faPlus, 
	     faMinus,
	     faChevronDown, 
	     faChevronUp, 
	     faSearch, 
	     faClipboard, 
	     faGraduationCap, 
	     faBook, 
	     faAddressBook, 
	     faUsers, 
	     faCogs, 
	     faHome,
	     faStar,
	     faCertificate,
	     faShoppingCart,
	     faIdBadge,
	     faChevronRight,
	     faChevronLeft,
		 faTimes,
		 faPlayCircle,
		 faTasks,
		 faPencilRuler,
		 faBars,
		 faLock

} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

Vue.use(vueVimeoPlayer);
Vue.use(VueRouter);
Vue.use(Vuex);
Vue.component('ToggleButton', ToggleButton);
Vue.component('star-rating', StarRating);
Vue.use(VueCurrencyFilter,
          {
            symbol : '₱',
            thousandsSeparator: ',',
            fractionCount: 0,
            fractionSeparator: '0',
            symbolPosition: 'front',
            symbolSpacing: false
          });

library.add({
	faPlay, 
	faPlus, 
	faMinus, 
	faChevronDown,
	faChevronUp,
	faSearch, 
	faClipboard, 
	faGraduationCap, 
	faBook, 
	faAddressBook, 
	faUsers,
	faCogs, 
	faHome,
	faStar,
	faCertificate,
	faShoppingCart,
	faIdBadge,
	faStar,
    faChevronRight,
    faChevronLeft,
	faTimes,
	faPlayCircle,
	faTasks,
	faPencilRuler,
	faBars,
	faLock
});

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('font-awesome-icon', FontAwesomeIcon);

Vue.config.productionTip = false

const store = new Vuex.Store({ 
	modules: {
		storeData,
	},
	plugins: [createPersistedState()]
});

const router = new VueRouter({
	routes : routes,
	mode: 'history',
	scrollBehavior (to, from, savedPosition) {
		if (savedPosition) {
		  return savedPosition
		} else {
		  return { x: 0, y: 0 }
		}
	}

});

initialize(store, router);

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
    	MainApp
    }
});
