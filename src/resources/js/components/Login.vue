<template>

<v-toolbar title="サービス名" v-bind:style="{ position: 'relative',background: '#FFF6E5', border: '3px solid #e0d6c3', borderRadius: '20px' }"
>

<v-btn v-on:click="register" v-bind:style="{ background: '#FFFBE5' }"
class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline">
    新規登録
</v-btn>


</v-toolbar>


    <!-- <h1>
        {{ store.username }}
    </h1>
    <h1>
        {{ store.email }}
    </h1>
    <h1>
        {{ store.hash }}
    </h1> -->

    <div
        v-bind:style="{ position: 'fixed', left: '50%', top: '50%', transform: 'translate(-50%, -50%)', width: '500px', height: '400px' }">
        <v-form ref="form" v-model="valid" lazy-validation>

            <v-text-field v-model="email" :rules="emailRules" label="メールアドレス" required></v-text-field>

            <v-text-field v-model="password" :rules="passwordRules" label="パスワード" required></v-text-field>


            <v-btn v-bind:style="{ left: '85%',background: '#FFFBE5' }"
                class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline"
               
                @click="validate"> ログイン

            </v-btn>




        </v-form>

        <!-- <v-btn @click="logout">Logout</v-btn>

        <v-btn @click="cookie">
            クッキーテスト
        </v-btn> -->

       

        <!-- <div>
            <v-btn @click="showList = !showList">Toggle List</v-btn>
            <v-list v-if="showList">
                <v-list-item v-for="item in items" :key="item.title" @click="menu = false">
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </div> -->

    </div>
</template>

<script>
import axios from 'axios';
import { register } from 'quill';
import { useCookies } from 'vue3-cookies'
import { store } from './store/store';


export default {

    data: () => ({

        // drawer: false,
        showList: false,
        items: [
            { title: 'Item 1' },
            { title: 'Item 2' },
            { title: 'Item 3' }
        ],

        // menu: true,
        // items: [
        //     { title: 'Item 1' },
        //     { title: 'Item 2' },
        //     { title: 'Item 3' }
        // ],
        test: "",
        valid: true,

        state: store(),

        email: '',
        emailRules: [
            v => !!v || 'メールアドレスは必須です',
            v => /.+@.+..+/.test(v) || '有効なメールアドレスである必要があります',
        ],
        password: '',
        passwordRules: [
            v => !!v || 'パスワードは必須です',
            v => (v && v.length >= 6 && v.length <= 12) || 'パスワードは6文字から12文字である必要があります',
            v => (v && /[A-Z]/.test(v) && /[a-z]/.test(v) && /\d/.test(v)) || 'パスワードは少なくとも1つの大文字、1つの小文字、1つの数字を含む必要があります'
        ],

    }),
    created() {
        const state = store();
        // console.log(store);
    },

    setup() {

    },

    methods: {
        async validate() {
            const { valid } = await this.$refs.form.validate()



            if (valid) {
                alert('こちらの内容でよろしいですか？')


                const email = this.email;
                const password = this.password;

                //後で関数にまとめる

                try {
                    // POSTリクエストを送信
                    const res = await axios.post('/api/login', {
                        email: email,
                        password: password
                    });

                    console.log(res);

                    //ログイン成功時、ユーザ情報を書き換え
                    this.state.login(res.data.username, email, res.data.hash);
                    this.state.screenState=4;

                    this.state.screen_transition();





                    // console.log(hash, email, username)


                    useCookies.set('hash', hash, {
                        expires: new Date().setDate(new Date().getDate() + 7) // 保存期間を 7 日に設定
                    })
                    useCookies.set('email', email, {
                        expires: new Date().setDate(new Date().getDate() + 7) // 保存期間を 7 日に設定
                    })
                    useCookies.set('username', username, {
                        expires: new Date().setDate(new Date().getDate() + 7) // 保存期間を 7 日に設定
                    })


                } catch (error) {
                    // エラー処理
                    // ...
                }


            }

        },
        reset() {
            this.$refs.form.reset()

        },
        resetValidation() {
            this.$refs.form.resetValidation()


        },


        cookie() {
            // cookie からハッシュを取得

            this.test = useCookies.get("hash");
        },

        register(){
            this.state.screenState = 2;

            this.state.screen_transition();
        }

        // async logout() {
        //     try {
        //         // ログアウトをリクエスト
        //         const res = await axios.post('/api/logout');

        //         console.log(res);
        //         // ログアウトに成功した場合、ユーザ情報をリセット
        //         this.store.logout();
        //     } catch (error) {
        //         console.error(error);
        //     }
        // },

    },

}
</script>