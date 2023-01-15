<template>







    <!-- <img src='http://localhost:8081/image/background_image.png'
        v-bind:style="{ position: 'fixed', top: '65%', left: '50%', transform: 'translate(-50%, -50%)' }"> -->

    <v-toolbar title="駆け出し部屋" v-bind:style="{ position: 'relative' }">
        <v-btn @click="register" v-bind:style="{
            boxShadow: '0 2px 4px rgba(0, 0, 0, 0.2)',
            fontweight: '700',
        
        }" class="mr-4 rounded-full px-4 py-2  hover:bg-gray-300 focus:outline-none focus:shadow-outline">
            新規登録
        </v-btn>
        <v-btn @click="login" v-bind:style="{
            boxShadow: '0 2px 4px rgba(0, 0, 0, 0.2)',
            fontweight: '700',
        
        }" class="mr-4 rounded-full px-4 py-2   hover:bg-gray-300 focus:outline-none focus:shadow-outline">
            ログイン
        </v-btn>

    </v-toolbar>

    <v-app>
        <v-content v-bind:style="{position:'relative'}">
            <v-container v-bind:style="{position:'absolute',top:'70%'}">
               


                <v-row >
          <v-col class="pr-section" cols="6">
            <h1 class="title">駆け出し部屋</h1>
            <p>プログラミングの勉強を始めてみたけどエラーでつまづいた、<br>
                「どうしよう」て考えた結果、質問サイトに質問を投げる事にした。<br>
                でも質問に対して指摘されまくってプログラミングを挫折、そうならないためのサービスが駆け出し部屋です。<br>
                何を質問していいかわかりません、そんな状態でも構いません、何でも気になる事は投げちゃってください。<br>
            </p>
            <!-- <v-btn color="primary">Learn More</v-btn> -->
          </v-col>
          <v-col cols="8">
            <!-- Your main content goes here -->
          </v-col>
        </v-row>
            </v-container>
        </v-content>
    </v-app>

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
        console.log("画面の状態");
        console.log(state.screenState);
        state.screen_transition();
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