<template>


    <v-toolbar 
        v-bind:style="{ position: 'relative' }">

        <template v-slot:title>
      <div @click="home" v-bind:style="{  position: 'fixed', left: '3%',top:'2%' }" class="px-4 py-2   hover:bg-gray-300 focus:outline-none focus:shadow-outline"
      >
        駆け出し部屋
      </div>
    </template>

        <v-text-field :loading="loading" density="compact" label="検索" append-inner-icon="mdi-magnify" single-line
            hide-details @click:append-inner="onClick"
            v-bind:style="{ position: 'fixed', left: '40%', width: '40%' }"></v-text-field>
        <v-btn v-on:click="showContent" v-bind:style="{  position: 'fixed', left: '83%' }"
            class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline">
            質問する
        </v-btn>


        <v-btn @click="account_menu = !account_menu" 
            class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline">
            {{ state.user_info.username }}

        </v-btn>



    </v-toolbar>
    <v-container>
        <v-row>
            <v-col cols="12" sm="6" md="4">
                <v-avatar size="120">
                    <!-- <img src="profile-image.jpg" alt="Profile Image"> -->
                </v-avatar>
            </v-col>
            <v-col cols="12" sm="6" md="8">
                <v-card>
                    <v-card-title>{{ userName }}</v-card-title>
                    <v-card-subtitle>{{ userBio }}</v-card-subtitle>
                    <v-card-text>
                        <v-row>
                            <!-- <v-col cols="12" sm="6">
                                <v-chip color="primary">Location</v-chip>
                                <v-chip label="{{ location }}" color="secondary">{{ location }}</v-chip>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-chip color="primary">Website</v-chip>
                                <v-chip label="{{ website }}" color="secondary">{{ website }}</v-chip>
                            </v-col> -->
                        </v-row>
                    </v-card-text>
                </v-card>



            </v-col>
        </v-row>
    </v-container>
    <v-container>
        <v-card>
            <v-card-title>自分自身の質問</v-card-title>
            <v-card-text>
                <template v-for="(question, index) in questions">
                    <v-list-item>
                        <v-list-item-title>{{ question.title }}</v-list-item-title>
                        <v-list-item-subtitle>{{ question.description }}</v-list-item-subtitle>
                    </v-list-item>
                    <v-divider></v-divider>
                </template>
            </v-card-text>
        </v-card>
    </v-container>
</template>
<script>
import { store } from './store/store';

export default {

    
   
    data: () => ({
        userName: store().user_info.username,
        userBio: "Software Developer",
        location: "San Francisco, CA",
        website: "https",
        questions: [
            { title: "#1054 - 列 'makers_id' は 'field list' にはありません。", description: "書籍の内容です。Chappter4-18「データベースのリレーション」P.179 [複数のテーブルを横断して検索する]" },
            { title: "dataframe型の二次元配列をソートしたい", description: "print(dataframe)で以下のように出力されるdataframe型二次元配列があります。" },
            { title: "[Rails] 1対多のテーブルからデータを取得する", description: "プログラミング初心者です。アプリを１から作成しているのですが、完全に詰まってしまったので、ご教授いただけると幸いです。" }
        ],

        state: store(),
    }),

    created(){
        const state = store();
        state.screen_transition();
    },

    methods: {
        home() {

            this.state.screenState = 4;
            this.state.screen_transition();

        }
    }
}

</script>