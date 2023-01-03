<template>







    <img src='http://localhost:8081/image/background_image.png'
        v-bind:style="{ position: 'fixed', top: '65%', left: '50%', transform: 'translate(-50%, -50%)' }">

    <v-toolbar title="サービス名"
        v-bind:style="{ position: 'relative', background: '#FFF6E5', border: '3px solid #e0d6c3', borderRadius: '20px' }">
        <v-btn @click="register" v-bind:style="{ background: '#FFFBE5' }"
        class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline">
            新規登録
        </v-btn>
        <v-btn @click="login" v-bind:style="{ background: '#FFFBE5' }"
        class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline">
            ログイン
        </v-btn>

    </v-toolbar>

</template>


<!-- <style lang="css">
.bg-image {
  background-image: url('http://localhost:8081/image/loading.png');
  background-repeat: repeat;
}
</style> -->

<script>

import { store } from './store/store';


export default {

    data: () => ({

        // drawer: false,



        state: store(),



    }),
    created() {
        const state = store();
        console.log(state);
        
    },

    setup() {

    },

    methods: {


        register() {
            this.state.screenState = 2;
            this.state.screen_transition();
        },

        login() {
            this.state.screenState = 3;
            this.state.screen_transition();
        }



    },

}
</script>