<template>
	<div>
		<!-- <form class="form-search form-inline mb-3 text-right align-right" @submit.prevent="getResults">
			<input type="text" class="form-control mr-2" v-model="inputSearch" placeholder="search"/>
			<input type="submit"  class="form-control btn btn-primary" value="Search" />
		</form> -->

       <table class="table">
	       	<thead>
                <th width="150">Name</th>
				<th>Info</th>
	       		<th>Action</th>
	       	</thead>
	       	<tbody>
	       		<template v-if="!entries">
	       			<tr>
	       				<td colspan="2" class="text-center">No exercises available</td>
	       			</tr>
	       		</template>
	       		<template v-else>
	       			<tr v-for="entry in entries.data" :key="entry.id">
						<td>
                            <div class="photo-wrap">
                                <img v-if="entry.user.image" :src="`/users/${ entry.user.image}`" width="32" height="auto" /> 
                                <img v-else src="/images/user_image.png" width="32" height="auto"  />
                            </div>
                            <span>{{ entry.user.firstname + " " + entry.user.lastname }}</span>
                            <div v-if="entry.has_passed != '0' && entry.has_passed != null">
                                <button class="alert alert-success alert-sm">Passed</button>
                            </div>
						</td>
                        <td>
                            <div class="content-info">
                                <strong>Exercise # {{entry.exercise.id}} : {{ entry.exercise.title}} </strong> 
                            </div>
                            <div class="student-entry">
                                <div v-html="entry.content"></div>
                            </div>
                            <div class="comment-info" v-if="entry.comment">
                                <div v-html="entry.comment"></div>
                            </div>

                        </td>
	       				<td width="200">
	       					<button class="btn btn-custom btn-sm btn-info" @click="showPop(entry.exercise.id, entry.user.id, entry.id)">Update</button>
                            <button class="btn btn-custom btn-sm btn-danger" @click="deleteEntry(entry.id)">Delete</button>
	       				</td>
	       			</tr>
	       		</template>	
	       	</tbody>
       </table>
        <div id="popupForm" v-bind:class="{'show': showPopup}">
            <form @submit.prevent="add()">
                <button class="close-btn" @click="showPop">Close</button>
                <p v-if="!message">Add comment</p>
                <div class="alert alert-success" v-else>{{ message }}</div>
                <VueEditor v-model="comment"></VueEditor>
               <span class="mt-4">Has passed?</span> 
                Put 1 if pass
                <input type="number" max="2" v-model="has_passed">
                <input type="submit" value="Submit" class="btn btn-primary" mt-3 />
            </form> 
        </div>
       <pagination :data="entries" :limit="5" @pagination-change-page="getResults"></pagination>
	</div>
</template>

<script>
import { VueEditor } from 'vue2-editor';
	export default {
        name: 'list',
        components: {
			VueEditor
	    },
		data() {
			return {
				entries: {},
                inputSearch: '',
                comment: '',
                exerciseActive: '',
                showPopup: false,
                message: '',
                has_passed: false,
                userActive: '',
                entryActive: ''
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser;
            },
            currentUserToken() {
				return this.$store.getters.currentUser.token;
			},
		},
		mounted() {
			this.getResults();
		},
		methods: {
            showPop(id, user_id, entry_id) {
                this.showPopup = !this.showPopup; 
                this.exerciseActive = id;
                this.userActive = user_id;
                this.entryActive = entry_id;
            },
			getResults( page = 1) {

				let keyword = this.inputSearch;
				if(keyword) {
					axios.get('/api/exercise-entry?page=' + page + '&keyword= ' + keyword, {
						headers: {
							"Authorization": `Bearer ${this.currentUser.token}`
						}
					})
					.then(response => {
						this.entries = response.data.exercises;
					});
				} else {
					axios.get('/api/exercise-entry?page=' + page, {
						headers: {
							"Authorization": `Bearer ${this.currentUser.token}`
						}
					})
					.then(response => {
                        console.log(response.data);
						this.entries = response.data.exercises;
					});
			
				}
			},
			search() {
				console.log('test....' + this.inputSearch);
            },
            add() {
                console.log(this.entryActive);
                axios.put(`/api/admin-exercises/update/${this.entryActive}`, {
                            'exercise_id' : this.exerciseActive,
                            'user_id' : this.userActive,
                            'comment': this.comment,
                            'has_passed' : this.has_passed
                    }, {
                        headers: {
                            "Authorization": `Bearer ${this.currentUserToken}`
                        }
                    })
                    .then((response) => {

                    if(response.data.success == true) {
                        this.message = "New comment has been successfully added."

                        setTimeout(function(){ window.location.reload() }, 2000);
                    }
                    })
                    .catch((error) => {
                            console.log(error);
                    });
            },
            deleteEntry(id) {
                console.log(id);
                axios.post(`/api/exercise-entry/delete/${id}`, {
                        headers: {
                            "Authorization": `Bearer ${this.currentUserToken}`
                        }
                    })
                    .then((response) => {
                        window.location.reload();

                        if(response.data.success == true) {
                            this.message = "Entry has been successfully deleted."

                           window.location.reload;
                        }
                    })
                    .catch((error) => {
                            console.log(error);
                    });
            }
		}
	}
</script>
<style scoped>
.btn-success {
    border-color: #8fe093;
    background-color: #8fe093;
}
.btn-info {
    border-color: #5eb2e6;
    background-color: #5eb2e6;
    color: #fff;
}
.photo-wrap {
    border-radius: 50%;
    width: 48px;
    height: 48px;
    overflow: hidden;

}
.photo-wrap img {
        object-fit: cover;
        width: 100%;
        height: 100%;
}
.student-entry {
    background: #f6fbff;
    padding: 9px;
}
.comment-info {
    margin-top: 5px;
    background: #fffcf8;
    padding: 9px;
}
.alert-sm {
    padding: 2px;
    font-size: 12px;
}
</style>