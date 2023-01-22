<template>

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

        <v-btn v-on:click="register" v-bind:style="{
            boxShadow: '0 2px 4px rgba(0, 0, 0, 0.2)',
            fontweight: '700',
        
        }"
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


    <v-dialog v-model="popupVisible">
        <v-card v-bind:style="{ position: ' relative' }">
            <!-- <v-card-title v-bind:style="{position:'absolute',top:'50%',left:'50%' }"> -->
            <v-card-title class="text-center">
                メールアドレスかパスワードが間違っています
            </v-card-title>
            <!-- <v-card-actions class="text-center">
                <v-btn @click="showDialog = false">Close</v-btn>
            </v-card-actions> -->
        </v-card>
    </v-dialog>




    <div
        v-bind:style="{ position: 'fixed', left: '50%', top: '50%', transform: 'translate(-50%, -50%)', width: '500px', height: '400px' }">
        <v-form ref="form" v-model="valid" lazy-validation>

            <v-text-field v-model="email" :rules="emailRules" label="メールアドレス" required></v-text-field>

            <v-text-field v-model="password" :rules="passwordRules" label="パスワード" required></v-text-field>


            <v-btn v-bind:style="{
                left: '85%',
                background: '#F9FBFE'
            }" class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline"
                @click="validate"> ログイン

            </v-btn>




        </v-form>


    </div>
</template>

<style>
v-card-title {
    font-size: 1.2rem;
}
</style>

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

        popupVisible: false

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
            this.state.screenState = 1;
            this.email = '';
            this.password = '';
            this.$refs.form.reset()

            this.state.screen_transition();
        },

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

                    console.log("サーバからの応答");
                    console.log(res);


                    if (res.data.error) {
                        console.log("エラーのデータ");
                        console.log(res.data.error);
                        this.popupVisible = true;
                        this.email = '';
                        this.password = '';
                    } else {
                        //ログイン成功時、ユーザ情報を書き換え
                        this.state.login(res.data.username, email, res.data.hash);
                        this.state.screenState = 4;

                        this.state.screen_transition();
                    }

                  





                    // console.log(hash, email, username)





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

        register() {
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