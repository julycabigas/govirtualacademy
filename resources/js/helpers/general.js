export function initialize(store, router) {

	router.beforeEach((to, from, next) => {

	    const authReq = to.matched.some(record => record.meta.requiresAuth);

	     const currentUser = store.getters.currentUser;

	     const isAdmin   = currentUser && currentUser.role == 1 ? true: false;
	     const isLoggedIn = store.getters.isLoggedIn;


	     if(authReq && !currentUser && !isLoggedIn) {
	     	next('/login');
	     } 
	     else if ( ( to.path == '/register' || to.path == '/register' ) && currentUser  && isLoggedIn) {
	     	next('/');
	     }
	     else if (
	     	 to.path == '/home' ||
	     	 to.path == '/admin' ||
	     	 to.path == '/admin/training' ||
	     	 to.path == '/admin/training/edit/:id' ||
	     	 to.path == '/admin/training/new' ||
	     	 to.path == '/admin/courses' ||
	     	 to.path == '/admin/courses/new' ||
	     	 to.path == '/admin/courses/:id' ||
	     	 to.path == '/admin/courses/delete/:id' ||
	     	 to.path == '/admin/courses/edit/:id' ||
	     	 to.path == '/admin/courses/lesson/:id' ||
	     	 to.path == '/admin/courses/examination/list/:id' ||
	     	 to.path == '/admin/videos' ||
	     	 to.path == '/admin/videos/new'||
	     	 to.path == '/admin/videos/delete/:id'||
	     	 to.path == '/admin/videos/edit/:id'||
	     	 to.path == '/admin/videos/:id'||
	     	 to.path == '/admin/purchases/'||
	     	 to.path == '/admin/purchases/:id'||
	     	 to.path == '/admin/purchases/edit/:id'||
	     	 to.path == '/admin/purchases/delete/:id'||
	     	 to.path == '/admin/students' ||
	     	 to.path == '/admin/students/new' ||
	     	 to.path == '/admin/students/:id' ||
	     	 to.path == '/admin/students/edit/:id' ||
	     	 to.path == '/admin/students/delete/:id' ||
	     	 to.path == '/admin/examination' ||
	     	 to.path == '/admin/examination/edit/:id' ||
	     	 to.path == '/admin/examination/new' ||
	     	 to.path == '/admin/certificates' ||
	     	 to.path == '/admin/certificates-request' ||
	     	 to.path == '/admin/reviews' ||
	     	 to.path == '/admin/reviews/delete/:id' ||
	     	 to.path == '/admin/posts' ||
	     	 to.path == '/admin/posts/delete/:id' ||
	     	 to.path == '/admin/posts/edit/:id' ||
	     	 to.path == '/admin/posts/:id' ||
	     	 to.path == '/admin/posts/new' ||
	     	 to.path == '/admin/settings' ||
	     	 to.path == '/admin/categories' ||
			 to.path == '/admin/categories/:id' ||
			 to.path == '/admin/tasks' ||
			 to.path == '/admin/tasks/:id' ||
			 to.path == '/admin/tasks/delete/:id' ||
			 to.path == '/admin/tasks/edit/:id' ||
			 to.path == '/admin/tasks/new' ||
			 to.path == '/admin/tasks/create' ||
			 to.path == '/admin/categories/:id' ||
			 to.path == '/admin/courses-group' ||
			 to.path == '/admin/courses-group/:id' ||
			 to.path == '/admin/courses-group/delete/:id' ||
			 to.path == '/admin/courses-group/edit/:id' ||
			 to.path == '/admin/courses-group/new' ||
			 to.path == '/admin/courses-group/create' 
	     	  ) 
	     {

	     	if(isLoggedIn && isAdmin) {
	     		next();
	     	} else {
	     		next('/');
	     	}

	     }
	     else if(to.path == '/login' && isLoggedIn) {
	     	next('/');
	     }
	     else if(!to.matched.length) {
	     	next('/404');
	     }
	     else {
	     	next();
	     }
	});

	axios.interceptors.response.use(null, (error) => {
		if(error.response.status == 401) {
			store.commit('logout');
			router.push('/login');
		}

		return Promise.reject(error);

	});

	if(store.getters.currentUser) {
	    setAuthorization(store.getters.currentUser.token);
	}
    
}
export function setAuthorization(token) {
    
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

}