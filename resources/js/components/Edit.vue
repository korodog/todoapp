<script>
    import axios from 'axios';

    export default{
        props: ["task"],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                auth: [],
                authCheck: [],
                task_name: '',
                isValidated: {
                    task_name: false
                },
                validationConditions: {
                    max: 40
                },
                validationErrorMessages: {
                    max: "40文字以下で書いて下さい。",
                    required: "文字を入力して下さい。",
                },
                validationErrorMessage: {
                    task_name: null
                },
                canSubmit: false,
                countMessage: ""
            }
        },
        mounted() {
            let vm = this;
            
            this.task_name = this.task.name;
            console.log(this.task);
            axios.get('/auth')
                .then(function (response) {
                    vm.auth = response.data;
                    console.log(response);
                })

            axios.get('/auth_check')
                .then(function (response) {
                    vm.authCheck = response.data;
                    console.log(response);
                })
        },
        methods: {
            update(id) {
                console.log(this.task_name);
                axios.post("/update/" + id,{
                    task_name: this.task_name
                },)
                .then(response => {
                    console.log(response);
                    location.href = '/'
                })
                .catch(error => {
                console.info(error)
                })
            },
        },
        watch: {
        task_name: function(newTask_name, oldTask_name) {
            if (this.task_name == '' || !this.task_name.match(/\S/g)) {
                this.validationErrorMessage.task_name = this.validationErrorMessages.required;
                this.isValidated.task_name = false;
                this.canSubmit = false;
                return;
            }
            if (this.task_name.length > this.validationConditions.max) {
                this.validationErrorMessage.task_name = this.validationErrorMessages.max;
                this.isValidated.task_name = false;
                this.canSubmit = false;
                return;
            }

            this.validationErrorMessage.task_name = null;
            this.isValidated.task_name = true;
            this.canSubmit = true;
            this.countMessage = "残り" + (this.validationConditions.max-this.task_name.length) + "文字まで入力可能です。"
            return;
        }
    },     
    }
</script>
<template>
    <div>
        <header>
        <div class="title1">
                <div class="title2">
                    <h1>Todoアプリ-編集画面</h1>
                </div>
                <div class="userName">
                <div v-if="authCheck">
                    <span>
                            USER: {{ auth.name }}
                        <a href="/logout">(ログアウト)</a>
                    </span>
                </div>
                <p v-else="authCheck">※ログインしていません。(<a href="/login">ログイン</a>|<a href="/register">登録</a>)</p>                    
            </div>
        </div>
        </header>
        <div>
            <div>
                    <div>
                        <div class="editTask">
                        <label>
                            <input type="text" name="task_name" v-model="task_name">
                        </label>
                        <div v-if="!isValidated.task_name" v-text="validationErrorMessage.task_name"></div>
                        <div v-if="isValidated.task_name" v-text="countMessage"></div>
                        </div>
                        <div class="editBack1">
                            <div class="editBack2">
                            <div class="editBack3">
                            <a href="/">
                                戻る
                            </a>
                            </div>
                            </div>
                            <div class="goEdit">
                            <button @click="update(task.id)" :disabled="!canSubmit">
                                編集する
                            </button>
                            </div>
                        </div>
                    </div>  
            </div>
        </div>
    </div>
</template>