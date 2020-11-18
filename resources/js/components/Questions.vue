<template>
    <div>
    <p><a class="btn btn-success mt-2" href="/showform">Upload Questions</a></p>
    <h1 v-if="edit">Update Question</h1>
    <h1 v-else>Add Question</h1>
    <form action="#" @submit.prevent="edit ? updateQuestion(question.id) : createQuestion()">
        <div class="form-group">
            <label>Question</label>
            <input v-model="question.question" type="text" name="question" class="form-control">
        </div>
        <div class="form-group">
            <label>Category</label>
            <input v-model="question.categories" type="text" name="categories" class="form-control">
        </div>
        <div class="form-group">
            <label>1st Choice</label>
            <input v-model="question.choice_1" type="text" name="choice_1" class="form-control">
        </div>
        <div class="form-group">
            <label>Correct Choice for Q1</label>
            <input v-model="question.is_correct_choice_1" type="text" name="is_correct_choice_1" class="form-control">
        </div>
        <div class="form-group">
            <label>2nd Choice</label>
            <input v-model="question.choice_2" type="text" name="choice_2" class="form-control">
        </div>
        <div class="form-group">
            <label>Correct Choice for Q2</label>
            <input v-model="question.is_correct_choice_2" type="text" name="is_correct_choice_2" class="form-control">
        </div>
        <div class="form-group">
            <label>3rd Choice</label>
            <input v-model="question.choice_3" type="text" name="choice_3" class="form-control">
        </div>
        <div class="form-group">
            <label>Correct Choice for Q3</label>
            <input v-model="question.is_correct_choice_3" type="text" name="is_correct_choice_3" class="form-control">
        </div>
        <div class="form-group">
            <label>4th Choice</label>
            <input v-model="question.choice_4" type="text" name="choice_4" class="form-control">
        </div>
        <div class="form-group">
            <label>Correct Choice for Q4</label>
            <input v-model="question.is_correct_choice_4" type="text" name="is_correct_choice_4" class="form-control">
        </div>
        <div class="form-group">
            <button v-show="!edit" type="submit" class="btn btn-primary">New Question</button>
            <button v-show="edit" type="submit" class="btn btn-primary">Update Question</button>
        </div>
    </form>
    <h1>Questions</h1>
    <ul class="list-group" v-for="question in list" v-bind:key="question.id">
        <li class="list-group-item">
            <strong>{{question.question}}</strong> {{question.categories}}
            <button @click="showQuestion(question.id)" class="btn btn-default btn-xs">Edit</button>
            <button @click="deleteQuestion(question.id)" class="btn btn-danger btn-xs">Delete</button>
        </li>
    </ul>
    </div>
</template>

<script>
    export default {
        data: function(){
            return {
                edit:false,
                list:[],
                question:{
                    question:'',
                    categories:'',
                    choice_1:'',
                    is_correct_choice_1:'',
                    choice_2:'',
                    is_correct_choice_2:'',
                    choice_3:'',
                    is_correct_choice_3:'',
                    choice_4:'',
                    is_correct_choice_4:''
                }
            }
        },
        mounted: function(){
            console.log('Questions Component Loaded...');
            this.fetchQuestionList();
        },
        methods: {
            fetchQuestionList:function(){
                console.log('Fetching questions...');
                axios.get('api/questions')
                    .then((response) => {
                        console.log(response.data.questions);
                        this.list = response.data.questions;
                    }).catch((error) => {
                        console.log(error);
                });
            },
            createQuestion: function(){
                console.log('creating question...');
                let self =  this;
                let params = Object.assign({}, self.question)
                axios.post('api/store', params)
                    .then(function(){
                        self.question.question = '';
                        self.question.categories = '';
                        self.question.choice_1 = '';
                        self.question.is_correct_choice_1 = '';
                        self.question.choice_2 = '';
                        self.question.is_correct_choice_2 = '';
                        self.question.choice_3 = '';
                        self.question.is_correct_choice_3 = '';
                        self.question.choice_4 = '';
                        self.question.is_correct_choice_4 = '';
                        self.edit = false;
                        self.fetchQuestionList();
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
            showQuestion: function(id){
                let self = this;
                axios.get('api/show/'+id)
                    .then(function(response){
                        console.log(response.data.question);
                        self.question.id = response.data.question.id;
                        self.question.question = response.data.question.question;
                        self.question.categories = response.data.question.categories;
                        self.question.choice_1 = response.data.question.choice_1;
                        self.question.is_correct_choice_1 = response.data.question.is_correct_choice_1;
                        self.question.choice_2 = response.data.question.choice_2;
                        self.question.is_correct_choice_2 = response.data.question.is_correct_choice_2;
                        self.question.choice_3 = response.data.question.choice_3;
                        self.question.is_correct_choice_3 = response.data.question.is_correct_choice_3;
                        self.question.choice_4 = response.data.question.choice_4;
                        self.question.is_correct_choice_4 = response.data.question.is_correct_choice_4;
                    })
                    self.edit = true;
            },
            updateQuestion: function(id){
                console.log('updating question '+id+'...');
                let self = this;
                let params = Object.assign({}, self.question);
                axios.patch('api/update/'+id, params)
                    .then(function(){
                        self.question.question = '';
                        self.question.categories = '';
                        self.question.choice_1 = '';
                        self.question.is_correct_choice_1 = '';
                        self.question.choice_2 = '';
                        self.question.is_correct_choice_2 = '';
                        self.question.choice_3 = '';
                        self.question.is_correct_choice_3 = '';
                        self.question.choice_4 = '';
                        self.question.is_correct_choice_4 = '';
                        self.edit = false;
                        self.fetchQuestionList();

                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
            deleteQuestion: function(id){
                axios.delete('api/delete/'+id)
                    .then(function(response){
                        // windows.location - refresh
                        self.fetchQuestionList();

                    })
                    .catch(function(error){
                        console.log(error);
                    });
            }
        }
    }
</script>