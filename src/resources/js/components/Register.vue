<template>


    <!-- <div>
        {{ test }}
    </div> -->

    <v-toolbar v-bind:style="{ position: 'relative' }">

        <template v-slot:title>
            <div @click="home" v-bind:style="{
                position: 'fixed',
                left: '3%',
                top: '2%',
                fontweight: '700',
            
            }" class=" px-4 py-2    focus:outline-none focus:shadow-outline">
                駆け出し部屋
            </div>
        </template>


        <v-btn @click="login" v-bind:style="{
            boxShadow: '0 2px 4px rgba(0, 0, 0, 0.2)',
            fontweight: '700',
        
        }"
            class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline">

            ログイン
        </v-btn>

    </v-toolbar>

    <div
        v-bind:style="{ position: 'fixed', left: '50%', top: '50%', transform: 'translate(-50%, -50%)', width: '500px', height: '400px' }">
        <v-form ref="form" v-model="valid" lazy-validation>
            <v-text-field v-model="username" :counter="10" :rules="usernameRules" label="名前" required></v-text-field>

            <v-text-field v-model="email" :rules="emailRules" label="メールアドレス" required></v-text-field>

            <v-text-field v-model="password" :rules="passwordRules" label="パスワード" required></v-text-field>


            <v-btn v-bind:style="{
                left: '85%',
                background: '#F9FBFE'
            }" class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline"
                @click="validate"> 登録

            </v-btn>




        </v-form>


    </div>
</template>

<script>
import axios from 'axios';
import { useCookies } from 'vue3-cookies'
import { store } from './store/store';

export default {



    data: () => ({
        test: "",
        valid: true,
        username: '',
        usernameRules: [
            v => !!v || '名前は必須です',
            v => (v && v.length <= 10) || '名前は10文字以内である必要があります',
        ],
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

        state: store(),

    }),

    created() {
        const state = store();
        state.screen_transition();
        // console.log(store);
    },

    setup() {

    },

    methods: {

       

        home() {



            this.username = '';
            this.email = '';
            this.password = '';
            this.$refs.form.reset()

            this.state.screenState = 1;

            
            
            this.state.screen_transition();
        },
        async validate() {
            const { valid } = await this.$refs.form.validate()



            if (valid) {
                alert('こちらの内容でよろしいですか？')

                const username = this.username;
                const email = this.email;
                const password = this.password;



                //後で関数にまとめる

                try {
                    // POSTリクエストを送信
                    const res = await axios.post('/api/register', {
                        username: username,
                        email: email,
                        password: password
                    });

                    console.log(res);

                    // レスポンスを処理
                    const hash = res.data.hash;



                    this.state.login(res.data.username, email, res.data.hash);
                    this.state.screenState = 4;

                    this.state.screen_transition();



                    console.log(hash, email, username)


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
        login() {
            this.state.screenState = 3;

            this.state.screen_transition();
        }

    },

}
</script>