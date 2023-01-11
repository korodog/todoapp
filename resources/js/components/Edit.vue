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
        }        
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
                            <button @click="update(task.id)">
                                編集する
                            </button>
                            </div>
                        </div>
                    </div>  
            </div>
        </div>
    </div>
</template>