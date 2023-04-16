<template>
    <div class="course-exerciselist">
        <div class="inner-exercise">
            <div class="inner-list">
                <template v-if="exerciselist.length > 0"> 
                    <div  id="accordionExercise">
                        <div class="card" v-for="(exercise, index) in exerciselist" :key="exercise.id" v-bind:class="[{'underline-header pass': exercise.has_passed}]">
                            <div class="content-header" :id="`exercise-${index}`" @click="showContent(index)">
                                <h2 class="mb-0">
                                  
                                        <strong>Exercise #{{doMath(index)}}</strong> <span v-bind:class="{'underline': exercise.completed }">{{exercise.title}}</span>
                                        <small>Click to open</small>
                                 
                                </h2>
                            </div>  
                            <div :id="`content-show-${index}`" class="content-exercise">
                                <div class="exercise-inner">

                                    <div class="exercise-info" v-html="exercise.description"></div>

                                    <div class="desc">
                                        <div class="entries">
                                            <button class="add-entry-btn" @click="showPop(exercise.id)">Add Entry</button>
                                            <div class="single-entry" v-for="(entry) in exercise.entry" :key="entry.id">
                                                <div class="status"><span v-if="entry.has_passed == true" class="alert alert-success">Passed</span></div>
                                                <strong>Entry #{{ entry.id }}</strong>
                                                <div v-html="entry.content"></div>
                                                <div class="team-entry" v-if="entry.comment">
                                                    <strong>Team Comment</strong>
                                                    <div v-html="entry.comment"></div>
                                                    <span>{{ entry.created_at }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="alert alert-info">No available exercises</div>
                </template>

                <div id="popupForm" v-bind:class="{'show': showPopup}">
                    
                    <form @submit.prevent="add()">
                        <button class="close-btn" @click="showPop">Close</button>
                            <div class="errors" v-if="errors">
                            <ul>
                                <li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
                                    <strong>{{ fieldName }}</strong> {{ fieldsError.join('\n') }}
                                </li>
                            </ul>
                        </div>
                        <p v-if="!message">Submit the requested info here. Note don't add the image in the editor, add the link of the image instead.</p>
                        <div class="alert alert-success" v-if="message && !errors">{{ message }}</div>
                        <VueEditor v-model="entry.content" required></VueEditor>
                        <input type="submit" value="Submit" class="btn btn-primary" mt-3 />
                    </form> 
                </div>

            </div>
            
        </div>
    </div>
</template>
<script>
import validate from 'validate.js';
import JQuery from 'jquery';
import { VueEditor } from 'vue2-editor';
 export default {
     name: 'portal-exercises',
     props: ['groupID'],
     components: {
			VueEditor
	},
     data() {
         return {
             exerciselist: {},
             entry: {
                 content: '',
             },
             message: '',
             showPopup:false,
             exerciseActive: '',
             errors: {}
             
         }
     },
    computed: {
			currentUser() {
				return this.$store.getters.currentUser;
			},
			currentUserToken() {
				return this.$store.getters.currentUser.token;
			},
			isActiveGroup() {
				return this.$store.getters.activeGroup;
			}
	},
	watch: {
			isActiveGroup(value) {
                this.checkComplete();
			}
    },
    created() {
        this.checkComplete();
        this.showContent();
    },
    methods: {
        showPop(id) {
            this.showPopup = !this.showPopup; 
            this.exerciseActive = id;
        },
        showContent(index) {
            let $ = JQuery;

            $('#exercise-' + index).closest('.card').find('.content-exercise').toggleClass('show');

        },
        doMath(index) {
            return index+1
        },
        checkComplete() {

            let $ = JQuery;
        
            axios.post(`/api/exercise-entry/check/${this.currentUser.id}`, {
                        'group_id' : this.groupID
                }, {
                    headers: {
                        "Authorization": `Bearer ${this.currentUserToken}`
                    }
                })
                .then((response) => {
                    this.exerciselist	= response.data.exercises;
 
                })
                .catch((error) => {
                        console.log(error);
                });
            
        },
        add() {

            this.errors       = null;
            const constraints = this.getConstraints();
            const errors 	  = validate(this.entry, constraints)

            if(errors) {
                this.errors = errors;
                return;
            }
                
            axios.post(`/api/student-exercises/new`, {
                        'exercise_id' : this.exerciseActive,
                        'user_id' : this.currentUser.id,
                        'content': this.entry.content,
                        'has_passed' : false
                }, {
                    headers: {
                        "Authorization": `Bearer ${this.currentUserToken}`
                    }
                })
                .then((response) => {
                   if(response.data.status == true) {
                       this.message = "New entry has been successfully submitted.";
                       this.checkComplete();
                   }
                })
                .catch((error) => {
                        console.log(error);
                });
        },
        getConstraints() {
				return {
					content: {
						presence: true, 
						length: {
							minimum: 5,
							message: 'Must be at least 5 characters long'
						}
					},
					
				}
			}
     }

 }
</script>
<style scoped>
.card.underline-header .card-header h2 button {
    text-decoration: line-through !important;
}
.team-entry {
    padding: 6px 10px;
    background: #fffaf4;
    margin-top: 10px;
}
.team-entry span {
    font-size: 14px;
    color: #c5baba;
}
.card-header h2:active, 
.card-header h2:focus {
    border: 0;
}
</style>