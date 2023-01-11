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

            taskComp(id) {
                axios.post("/comp/" + id)
                .then(response => {
                    console.log(response);
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
        <form action="/" method="post">
            <div class="todoInput">
                <label>
                    <input type="text" placeholder="今日やることを記入して下さい。" name="task_name">
                </label>
                <button type="submit">追加する</button>
            </div>
        </form>
        <span>完了済みのタスクを表示</span><input type="checkbox" v-model="comp_check">
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
                                                <form @click="taskComp(comp_task.id)">
                                                    <input type="hidden" name="_token" :value="csrf">
                                                    <input type="hidden" name="task_status" :value="true">
                                                    <button type="submit">
                                                        完了
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="edit">
                                                <a :href="'/edit/' + comp_task.id">編集</a>
                                            </div>
                                            <div class="delete">
                                                <form @click="taskDelete(comp_task.id)">
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
            </div>
        <footer>
            <p class="footerTitle">Todoアプリ</p>
        </footer>
    </div>
</template>