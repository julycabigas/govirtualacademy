<template>
    <div>
        <template v-if="tasklist.length > 0">
            <div class="course-tasklist">
                <div class="inner-task">
                    <div class="inner-list">
                      
                            <div class="card-exam" v-for="(task, index) in tasklist" :key="task.id" v-bind:class="[{'underline': task.completed}]">
                                <div class="content-header" :id="`exam-${index}`" @click="showContent(index)">
                                    <h2>
                                        <strong>Task {{doMath(index)}}</strong> <span v-bind:class="{'underline': task.completed }">{{task.name}}</span> 
                                        <template v-if="task.name != task.description">
                                            <small>Click for more info</small>
                                        </template>
                                    </h2>
                                </div>  
                                <div class="content-exercise" v-if="task.name != task.description">
                                    <div class="exercise-inner">
                                        <template>
                                            <div class="desc">
                                                <div v-html="task.description"></div>
                                                <template v-if="task.notes">
                                                    <div class="task-note">
                                                        <div v-html="task.notes"></div>	
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                       

                    </div>
                    
                </div>
            </div>
        </template>
        <template v-else>
             <div class="alert alert-info">No task available</div>
        </template>

    </div>
</template>
<script>
import JQuery from 'jquery';
 export default {
     name: 'portal-tasks',
     props: ['groupID'],
     data() {
         return {
             tasklist: {}
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
        doMath(index) {
            return index+1
        },
        showContent(index) {
            let $ = JQuery;
            $('#exam-' + index).closest('.card-exam').find('.content-exercise').toggleClass('show');
            console.log();
        },
        checkComplete() {

            let $ = JQuery;
        
            axios.post(`/api/task-entry/check/${this.currentUser.id}`, {
                        'group_id' : this.groupID
                }, {
                    headers: {
                        "Authorization": `Bearer ${this.currentUserToken}`
                    }
                })
                .then((response) => {
    
                    this.tasklist	= response.data.tasks;
 
                })
                .catch((error) => {
                        console.log(error);
                });
            
        },
     }

 }
</script>
<style scoped>
.content-header {
    padding: 15px 0;
}
.content-header h2 {
    margin: 0;
    font-size: 16px;
}
.content-header h2 small {

    color: #f6961e;

}
.card-body {
    margin-bottom: 20px;
    background: #fff;
    border: 1px solid #f5f5f5;
}
.card-header {
    background: #f7f7f7;
    padding: 5px;
    border: 1px solid #f5f5f5;
    border-bottom: 0;
}
.inner-list .row > div {
    margin-bottom: 10px;
}
.exercise-inner .desc {
    background: #f7f7f7;
}
</style>