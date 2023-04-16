import { getLocalUser } from './helpers/auth';

const user = getLocalUser();

const state = {
		currentUser: user,
		test: true,
		isLoggedIn: !!user,
		loading: false,
		auth_error: null,
		customers: [],
		videos: [],
		courses: [],
		categories: [],
		students: [],
		posts: [],
		roles: [],
		reviews: [],
		certificates: [],
		access_levels: [],
		inCart: [],
		activeCourse: '',
		activeGroup: '',
		isLock: false
	};
const getters = {
		isLoggedIn: (state) => state.isLoggedIn,
		isLoading: (state) => state.loading,
		currentUser: (state) => state.currentUser,
		authError: (state) => state.auth_error,
		customers: (state) => state.customers,
		videos: (state) => state.videos,
		courses: (state) => state.courses,
		categories: (state) => state.categories,
		students: (state) => state.students,
		posts: (state) => state.posts,
		roles: (state) => state.roles,
		reviews: (state) => state.reviews,
		certificates: (state) => state.certificates,
		access_levels: (state) => state.access_levels,
		inCart: (state) => state.inCart,
		activeCourse: (state) => state.activeCourse,
		activeGroup: (state) => state.activeGroup,
		activeBadges: (state) => state.activeBadges,
		isLock: (state) => state.isLock
	}

const mutations = {
		login(state) {
			state.loading = true;
			state.auth_error = null;
		},
		loginSuccess(state, payload) {
			state.auth_error = null;
			state.isLoggedIn = true;
			state.loading = false;
			state.currentUser = Object.assign({}, payload.user, {token: payload.access_token});

			localStorage.setItem("user", JSON.stringify(state.currentUser));
		},
		loginFailed(state, payload) {
			state.loading = false;
			state.auth_error = payload.error;
		},
		logout(state) {
			localStorage.removeItem("user");
			state.isLoggedIn = false;
			state.currentUser = null;
		},
		updateVideos(state, payload) {
			state.videos = payload;
		},
		updateCourses(state, payload) {
			state.courses = payload;	
		},
		updateCategories(state, payload) {
			state.categories = payload;
		},
		updateStudents(state, payload) {
			state.students = payload;
		},
		updatePosts(state, payload) {
			state.posts = payload;
		},
		updateRoles(state, payload) {
			state.roles = payload;
		},
		updateReviews(state, payload) {
			state.reviews = payload;
		},
		updateCertificates(state, payload) {
			state.certificates = payload;
		},
		updateAccessLevels(state, payload) {
			state.access_levels = payload;
		},
		updateCart(state, payload) {

			state.inCart = payload;
			localStorage.setItem("inCart", JSON.stringify(state.inCart));
		},
		updateActiveCourse(state, payload) {
			
			state.activeCourse = payload;
		},
		updateActiveGroup(state, payload) {
			
			state.activeGroup = payload;
		},
		updateActiveBadges(state, payload) {
			
			state.activeBadges = payload;
		},
		updateLock(state, payload) {
			
			state.isLock = payload;
		}

	};

const actions = {

		login( context ) {
			context.commit("login")
		},
		getVideos(context) {
			axios.get('/api/videos')
			.then((response) => {
				context.commit('updateVideos', response.data.videos)
			})
		},
		getCourses(context) {
			axios.get('/api/courses')
			  .then((response) => {
				context.commit('updateCourses', response.data.courses)
			  })
		},
		getCategories(context) {
			axios.get('/api/categories')
				 .then((response) => {
				 	context.commit('updateCategories', response.data.categories)
				 })
		},
		getStudents(context) {
			axios.get('/api/students')
				.then((response) => {
					context.commit('updateStudents', response.data.students )
				})
		},
		getPosts(context) {
			axios.get('/api/posts')
				.then((response) => {
					context.commit('updatePosts', response.data.posts )
				})
		},
		getReviews(context) {
			axios.get('/api/reviews')
				.then((response) => {
					context.commit('updateReviews', response.data.reviews )
				})
		},
		getRoles(context) {
			axios.get('/api/roles')
				.then((response) => {
					context.commit('updateRoles', response.data.roles)
				})
		},
		getCertificates(context) {
			axios.get('/api/certification')
				.then((response) => {
					context.commit('updateCertificates', response.data.certifications)
				})
		},
		getAccessLevels(context) {
			axios.get('/api/access')
				.then((response) => {
					context.commit('updateAccessLevels', response.data.access_levels)
				})
		},
		addInCart({ commit }, items ) {

			commit('updateCart', items);
		},
		removeInCart({ commit }, items ) {

			commit('updateCart', items);
		},
		setActiveCourse({commit}, course_id) {
			commit('updateActiveCourse', course_id)
		},
		setActiveGroup({commit}, group_id) {
			commit('updateActiveGroup', group_id)
		},
		setActiveBadges({commit}, badges) {
			commit('updateActiveBadges', badges)
		},
		setLock({commit}, lock) {
			commit('updateLock', lock)
		}

}

export default {
	state,
	getters,
	actions,
	mutations, 
};