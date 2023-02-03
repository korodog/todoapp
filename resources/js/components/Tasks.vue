<script>
    import axios from 'axios';

    export default{
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                auth: [],
                authCheck: [],
                tasks: [],
                comp_check: false,
                comp_tasks: [],
                task_name: '',
                delete_check: [],
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

            axios.get('/tasks')
                .then(function (response) {
                    vm.tasks = response.data;
                    console.log(response);
                })
            axios.get('/comp_tasks')
                .then(function (response) {
                    vm.comp_tasks = response.data;
                    console.log(response);
                })

        },
        methods: {
            taskDelete(id) {
                axios.delete("/delete/" + id)
                .then(function (response) {
                })
            },

            select_delete() {
                console.log(this.delete_check);
                axios.post("/select_delete", {select_data: this.delete_check})
                .then(function (response) {
                })
            },

            taskComp(id) {
                axios.post("/comp/" + id)
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                console.info(error)
                })
            },

            add_task() {
                axios.post("/", {
                    task_name: this.task_name
                })
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                console.info(error)
                })
            },

            cantSubmit() {
                if(this.task_name == ''){
                    return canSubmit = true;
                }
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
                        <h1>Todoアプリ</h1>
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
        <div v-if="authCheck">
        <div class="todo">
            <p>やること</p>
        </div>
        <form>
            <div class="todoInput">
                <label>
                    <input type="text" placeholder="今日やることを記入して下さい。" name="task_name" v-model="task_name">
                </label>
                <button @click="add_task()" type="submit" :disabled="!canSubmit">追加する</button>
                <div v-if="!isValidated.task_name" v-text="validationErrorMessage.task_name" style="color: red"></div>
                <div v-if="isValidated.task_name" v-text="countMessage"></div>
            </div>
        </form>
        <span style="margin-left: 20px;">完了済みタスクを表示</span><input type="checkbox" v-model="comp_check">
        <div v-if="comp_check" class="delete">
            <form @click="select_delete(delete_check)">
                <button type="submit" style="margin-left: 20px">
                    まとめて削除
                </button>
            </form>
        </div>
        <div v-if="comp_check">
            <div class="taskTable1">
                <div class="taskTable2">
                    <table>
                        <thead>
                            <tr>
                                <th id="thTask" scope="col">完了済タスク</th>
                                <th scope="col">
                                    <span>Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr v-for="comp_task in comp_tasks" :key="comp_task.id">
                                    <td>
                                        <div class="taskName">
                                            {{ comp_task.name }}
                                        </div>
                                    </td>
                                    <td class="complete1">
                                        <div class="complete2">
                                            <div class="complete3">
                                                <input type="checkbox" :value="comp_task.id" v-model="delete_check">
                                            </div>
                                            <div class="edit">
                                                <a :href="'/edit/' + comp_task.id">編集</a>
                                            </div>
                                            <div class="delete">
                                                <form @click="taskDelete(comp_task.id)">
                                                    <button type="submit">
                                                        削除
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>    

        <div v-else="comp_check">
            <div class="taskTable1">
                <div class="taskTable2">
                    <table>
                        <thead>
                            <tr>
                                <th id="thTask" scope="col">タスク</th>
                                <th scope="col">
                                    <span>Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr v-for="task in tasks" :key="task.id">
                                    <td>
                                        <div class="taskName">
                                            {{ task.name }}
                                        </div>
                                    </td>
                                    <td class="complete1">
                                        <div class="complete2">
                                            <div class="complete3">
                                                <form @click="taskComp(task.id)">
                                                    <input type="hidden" name="_token" :value="csrf">
                                                    <input type="hidden" name="task_status" :value="true">
                                                    <button type="submit">
                                                        完了
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="edit">
                                                <a :href="'/edit/' + task.id">編集</a>
                                            </div>
                                            <div class="delete">
                                                <form @click="taskDelete(task.id)">
                                                    <input type="hidden" name="_token" :value="csrf">
                                                    <button type="submit">
                                                        削除
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>    
        </div>
            <div v-else="authCheck">
                <p>※ログインして下さい。</p>
                <p>テスト用 mail:test@test PW:test1234</p>
            </div>
        <footer>
            <p class="footerTitle">Todoアプリ</p>
        </footer>
    </div>
</template>