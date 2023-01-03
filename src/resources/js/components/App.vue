
<template>
  <div class="vl-parent">
    <loading v-model:active="isLoading" :can-cancel="true" :on-cancel="onCancel" :is-full-page="true">


      <video src="http://localhost:8081/video/Now-Loading.mp4"></video>

    </loading>



  </div>


  <v-toolbar title="サービス名"
    v-bind:style="{ position: 'relative', background: '#FFF6E5', border: '3px solid #e0d6c3', borderRadius: '20px' }">

    <!-- <v-text-field :loading="loading" density="compact" variant="solo" label="検索" append-inner-icon="mdi-magnify"
      single-line hide-details @click:append-inner="onClick" ></v-text-field> -->

    <v-text-field :loading="loading" density="compact" label="検索" append-inner-icon="mdi-magnify" single-line
      hide-details @click:append-inner="onClick"
      v-bind:style="{ position: 'fixed', left: '40%', width: '40%' }"></v-text-field>
    <v-btn v-on:click="showContent" v-bind:style="{ background: '#FFFBE5', position: 'fixed', left: '83%' }"
      class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline">
      質問する
    </v-btn>


    <v-btn @click="account_menu = !account_menu" v-bind:style="{ background: '#FFFBE5' }"
      class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline">
      {{ state.user_info.username }}

    </v-btn>



  </v-toolbar>








  <div id="content" v-if="contentVisible"
    v-bind:style="{ backgroundColor: 'rgba(0, 0, 0, 0.3)', zIndex: 1, position: 'fixed', top: '0', left: '0', width: '100%', height: '100%' }">




    <div class="rounded-lg"
      v-bind:style="{ zIndex: 2, position: 'fixed', top: '50%', left: '50%', width: '85%', height: '85%', transform: 'translate(-50%, -50%)', background: '#FFF6E5' }">


      <v-btn v-on:click="hiddenContent" v-bind:style="{ background: '#FFFBE5', left: '80%' }"
        class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline">
        閉じる
      </v-btn>

      <v-btn v-on:click="editorContent" v-bind:style="{ background: '#FFFBE5', left: '80%' }"
        class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline">
        投稿する
      </v-btn>



      <v-text-field :loading="loading" density="compact" label="タイトル" append-inner-icon="mdi-magnify" single-line
        hide-details @click:append-inner="onClick"></v-text-field>
      <v-select class="custom-select" v-model="value" :items="items" chips label="カテゴリ" multiple>

      </v-select>
      <div v-bind:style="{ height: '50%', overflow: 'auto', background: '#FFFBE5' }">

        <QuillEditor :options="options" ref="editor" @blur="onEditorChange" />
      </div>

    </div>

  </div>



  <!-- 質問一覧画面 -->
  <v-card elevation="2" v-bind:style="{ position: 'relative', zindex: 0, background: '#FFF6E5' }">



    <v-col cols="12" class="d-flex align-center " v-for="(item, index) in list.data.data.slice(0, 19)"
      v-bind:style="{ zindex: 0, background: '#FFFBE5' }">



      <div class="flex flex-col w-full py-6 px-4  rounded-lg shadow-lg">
        <div class="flex items-center py-2">
        </div>
        <div class="py-2">
          <h2 class="text-xl font-bold text-gray-800">{{ item.title }}</h2>
        </div>
        <div class="flex items-center py-2">
          <p class="text-gray-600 mr-4">{{ item.tag }}</p>
          <p class="text-gray-600 mr-4">回答数: {{ item.answer_count }}</p>
          <p class="text-gray-600 mr-4">解決済み: {{ item.is_soved }}</p>
        </div>
        <div class="flex items-center py-2">
          <p class="text-gray-600 mr-4">投稿者: {{ item.user_name }}</p>
          <p class="text-gray-600 mr-4">閲覧数: {{ item.view_count }}</p>

        </div>
      </div>


    </v-col>

  </v-card>

  <v-list v-if="account_menu" v-bind:style="{
  zindex: 2, position: 'fixed', left: '91%'
  , top: '8%', background: '#FFFBE5'
}">
    <!-- <v-list-item v-for="item in it" :key="item.title" @click="menu = false" v-bind:style="{zindex:2}"

                
                > -->


    <v-list-item @click="menu = false" v-bind:style="{ zindex: 2, background: '#FFFBE5' }">


      <v-list-item-title class="text-gray-600">ホーム</v-list-item-title>
    </v-list-item>

    <v-list-item @click="menu = false" v-bind:style="{ zindex: 2, background: '#FFFBE5' }">
      <v-list-item-title class="text-gray-600" @click="logout">ログアウト</v-list-item-title>
    </v-list-item>
    <v-list-item @click="menu = false" v-bind:style="{ zindex: 2, background: '#FFFBE5' }">
      <v-list-item-title class="text-gray-600">ヘルプ</v-list-item-title>
    </v-list-item>

  </v-list>

  <div>
    <v-pagination v-model="page" :length=list.data.last_page></v-pagination>

  </div>


</template>


<style>
.v-input__control {
  background: #FFFBE5;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.ql-editor {
  background: #FFF6E5;
}

.custom-select {
  background: #FFFBE5;
}
</style>
<script >

import { ref } from 'vue'
import { useRoute, onBeforeRouteUpdate } from 'vue-router'
import axios from 'axios'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { store } from './store/store';

export default {
  name: 'Articles',



  data: () => ({

    account_menu: false,
    it: [
      { title: 'ホーム' },
      { title: 'ログアウト' },
      { title: 'ヘルプ' }
    ],

    isLoading: true,
    contentVisible: false,
    edit: "",

    state: store(),

    options: {
      // debug: 'info',
      modules: {
        syntax: true,
        toolbar: [{ 'header': 1 }, { 'header': 2 }, 'bold', 'italic', 'underline', 'code-block', 'image', 'video', { 'list': 'ordered' }, { 'list': 'bullet' }]

      },
      placeholder: 'xx',
      readOnly: false,
      theme: 'snow',


    },

    items: ['Babbage', 'Ballerina', 'Bash', 'D', 'Dart', 'Darwin', 'DataFlex', 'Ease', 'Easy PL/I', 'EASYTRIEVE PLUS', 'F#', 'Fortran', 'Go', 'Groovy', 'Haskell', 'Java', 'JavaScript', 'Julia', 'Kotlin', 'Lisp', 'Logo', 'Lua', 'MATLAB', 'Objective-C', 'OCaml', 'Pascal', 'Perl', 'PHP', 'Prolog', 'Python', 'R', 'Ruby', 'Rust', 'Scala', 'Swift', 'Visual Basic', 'Xojo'],
    value: [],





  }),
  mounted() {

  },

  computed: {
    editor: {
      get() {
        return this.$refs.editor
      }
    }

  },
  components: {
    Loading,
    QuillEditor
  },

  methods: {
    showContent() {
      this.contentVisible = true

    },
    hiddenContent() {
      this.contentVisible = false

    },

    editorContent() {
      const attributes_array = ["header", "code-block"];

      console.log(this.editor.getContents());

      var data = this.editor.getContents();


      const edit_data = data.ops;



      //配列のサイズを取得
      const edit_data_size = edit_data.length;

      console.log("配列のサイズ:" + edit_data_size);

      const question_content_json = [];



      for (let i = 0; i < edit_data_size*10; i++) {
        question_content_json.push({
          "attributes": "", "contents": ""
        });
      }


      console.log(question_content_json);


      //n回目に任意のキーがあった場合、n-1個目の要素のinsertキーを取り出す


      // 条件としてはi=2


      //問題としてはコードブロックで1行目が空の時
      //単純に空の行

      //タイトルの取得
      //カテゴリの取得
      //ユーザ名の取得

      // function find_slice(i) {

      //   if (edit_data[i].hasOwnProperty("insert")) {

      //     if (edit_data[i - 1]["insert"].indexOf("'\n'") === -1) {

      //       question_content_json[i]["contents"] = edit_data[i - 1]["insert"];

      //     } else {

      //       const regex = new RegExp(`(.*)\n(.*)`);
      //       const result = edit_data[i - 1]["insert"].match(regex)[2];

      //       question_content_json[i]["contents"] = result;
      //     }
      //   }
      // }

      function find_slice(str) {

        //改行文字で分割
        const lines = str.split('\n');


        const linse_size = lines.length;

        return lines[linse_size - 1];
      }



      //新規
      for (let i = 0; i < edit_data_size; i++) {
        console.log(i);
        console.log("今日も一日頑張ろう！");
        //ノーマルテキストの処理
        //現要素が属性値でなかった場合
        if (!edit_data[i].hasOwnProperty("attributes")) {
          console.log("明日も元気にいこう！");


          //次の要素が存在しなかった場合
          if (!(edit_data[i + 1] == undefined)) {

            console.log("レッツラゴー");
            //次の要素に属性値がなかった場合
            if (!edit_data[i + 1].hasOwnProperty("attributes")) {
              //全文字列をjsonに格納
              console.log("希望を持っていこう！");
              question_content_json[i]["attributes"] = "p";
              question_content_json[i]["contents"] = edit_data[i]["insert"];


              //次の要素が存在する場合
            } else {
              console.log("自分を信じていこう！");
              //次の要素が存在するかどうか

              //次の要素が装飾文字の場合　ノーマルテキストの場合の処理
              if (edit_data[i + 1].attributes.hasOwnProperty("bold") || edit_data[i + 1].attributes.hasOwnProperty("underline") || edit_data[i + 1].attributes.hasOwnProperty("italic")) {

                console.log("自分で選んだ道を進んでいこう！");


                if (edit_data[i]["insert"].indexOf("'\n'") === -1) { //改行文字が踏まれない場合
                  console.log("目標を持っていこう！");

                  //全文字列をjsonに格納
                  question_content_json[i]["attributes"] = "p";
                  question_content_json[i]["contents"] = edit_data[i]["insert"];

                } else { //改行文字が踏まれる場合
                  console.log("一歩一歩前に進んでいこう！");




                  //改行文字で分割
                  const lines = edit_data[i]["insert"].split('\n');


                  const linse_size = lines.length;


                  //行ごとに順番にjosnに値を格納
                  for (let j = 0; j < linse_size; j++) {
                    question_content_json[i + j]["attributes"] = "p";
                    question_content_json[i + j]["contents"] = lines[j];

                  }



                }


              }
              //次の要素の属性が装飾文字じゃなかった場合(属性値がヘッダーかコード)
              else {
                console.log("自分らしさを大切にしよう！");
                // 属性値がヘッダーだった場合
                if (edit_data[i + 1].attributes.hasOwnProperty("header")) {
                  //ヘッダーのサイズを判断
                  console.log("今を大切に生きよう！");


                  const header_size = edit_data[i + 1].attributes.header;


                  const lines = edit_data[i]["insert"].split('\n');
                  const linse_size = lines.length;
                  const normal_insert_value = lines;
                  

                  for (let j = 0; j <= linse_size - 2; j++) {
                   
                    question_content_json[i+j]["attributes"] = "p";
                    question_content_json[i+j]["contents"] = normal_insert_value[j];
                  }


                  //ヘッダーのテキストに当たる部分を取得
                  const insert_value = find_slice(edit_data[i]["insert"]);

                  question_content_json[i+linse_size - 1]["attributes"] = "h" + header_size;
                  question_content_json[i+linse_size - 1]["contents"] = insert_value;

                  i=i+linse_size - 1;

                  // 属性値がコードブロックだった場合
                } else {
                  console.log("自分を愛していこう！");
                  //コードブロックのテキストに当たる部分を取得


                  const lines = edit_data[i]["insert"].split('\n');
                  const linse_size = lines.length;
                  const normal_insert_value = lines;
                  

                  for (let j = 0; j <= linse_size - 2; j++) {
                   
                    question_content_json[i+j]["attributes"] = "p";
                    question_content_json[i+j]["contents"] = normal_insert_value[j];
                  }

                  

                  // question_content_json[i+]["attributes"] = "p";
                  // question_content_json[i+]["contents"] = normal_insert_value;


                  const code_insert_value = find_slice(edit_data[i]["insert"]);

                  question_content_json[i + linse_size - 1]["attributes"] = "code";
                  question_content_json[i + linse_size - 1]["contents"] = code_insert_value;

                  i=i+linse_size - 1;

                }

                
              }



            }
            //ノーマルテキストだけの場合
          }else{
            const lines = edit_data[i]["insert"].split('\n');
                  const linse_size = lines.length;
                  const normal_insert_value = lines;
                  

                  for (let j = 0; j <= linse_size - 1; j++) {
                   
                    question_content_json[i+j]["attributes"] = "p";
                    question_content_json[i+j]["contents"] = normal_insert_value[j];
                  }

                  i=i+linse_size

          }

          //現要素が属性値だった場合
        } else {
          console.log("周りの人を思いやろう！");
          //装飾文字だった場合
          if (edit_data[i].attributes.hasOwnProperty("bold") || edit_data[i].attributes.hasOwnProperty("underline") || edit_data[i].attributes.hasOwnProperty("italic")) {
            console.log("幸せを見つけよう！");
            //次の要素が属性値だった場合
            if (!(edit_data[i + 1].attributes == undefined)) {
              //次の要素の属性値がヘッダーだった場合
              console.log("小さな喜びを大切にしよう！");
              if (edit_data[i + 1].attributes.hasOwnProperty("header")) {
                //ヘッダーのサイズを判断
                console.log("感謝を忘れずにいこう！");
                const header_size = edit_data[i + 1].attributes.header;


                //装飾文字が太字だった場合
                if (edit_data[i].attributes.hasOwnProperty("bold")) {
                  console.log("今日も笑顔でいこう！");
                  question_content_json[i]["attributes"] = "h" + header_size + ",b";
                  question_content_json[i]["contents"] = edit_data[i].insert;

                }

                //装飾文字がアンダーラインだったっ場合
                else if (edit_data[i].attributes.hasOwnProperty("underline")) {
                  console.log("前向きに考えよう！");
                  question_content_json[i]["attributes"] = "h" + header_size + ",u";
                  question_content_json[i]["contents"] = edit_data[i].insert;


                  //装飾文字が斜体文字だった場合
                } else {
                  console.log("問題を解決するために努力しよう！");
                  question_content_json[i]["attributes"] = "h" + header_size + ",i";
                  question_content_json[i]["contents"] = edit_data[i].insert;

                }

                i++;


                //次の要素が装飾文字だった場合
              }


            } else {

              //装飾文字が太字だった場合
              if (edit_data[i].attributes.hasOwnProperty("bold")) {
                console.log("新しいことに挑戦しよう！");
                question_content_json[i]["attributes"] = "b";
                question_content_json[i]["contents"] = edit_data[i].insert;

              }

              //装飾文字がアンダーラインだったっ場合
              else if (edit_data[i].attributes.hasOwnProperty("underline")) {
                console.log("今日も一日を大切に生きよう！");
                question_content_json[i]["attributes"] = "u";
                question_content_json[i]["contents"] = edit_data[i].insert;


                //装飾文字が斜体文字だった場合
              } else {
                console.log("周りの人たちと感謝を交わそう");
                question_content_json[i]["attributes"] = "i";
                question_content_json[i]["contents"] = edit_data[i].insert;

              }
            }




          }



        }


      }






      // for (const [key, value] of Object.entries(question_content_json)) {
      //   if (!value) {
      //     delete question_content_json[key];
      //   }
      // }

      //空の要素を削除
      // for (let i = 0; i < edit_data_size*10; i++) {
      //   if (question_content_json[i].contents === "") {
      //     delete question_content_json[i].attributes;
      //     delete question_content_json[i].contents;
      //   }
      // }

      const json = question_content_json.filter(obj => obj.attributes !== "" && obj.contents !== "");

      


      console.log(json);





      // try {

      //   const res = axios.post('/api/logout');


      // } catch (error) {
      //   console.error(error);
      // }












    },

    async logout() {
      try {
        // ログアウトをリクエスト
        const res = await axios.post('/api/logout');

        console.log(res);
        // ログアウトに成功した場合、ユーザ情報をリセット
        this.state.logout();
        this.state.screenState = 1;
        this.account_menu = false;
        this.state.screen_transition();
      } catch (error) {
        console.error(error);
      }
    },

  },


  created() {

    const state = store();
    axios.post('/api/pagination', {
      newValue: 1
    })
      .then(res => {

        // console.log(res);
        this.list = res;


      })
      .catch(error => {
        console.log(error);
      });


  },
  setup() {
    const route = useRoute();
    const perpage = 10;
    let page = ref(0);
    let offset = 5;
    let list = ref([]);



    if (null != route && route.query) {
      page.value = (route.query.page) ? parseInt(route.query.page) : 1;
    } else {
      page.value = 1;
    }

    const setOffset = () => {


      offset = (page.value > 0) ? (page.value - 1) * perpage : 0;

    }

    setOffset()

    onBeforeRouteUpdate(async (to, from) => {
      if (to.query.page !== from.query.page) {
        page.value = to.query.page;
        setOffset()
      }
    })

    // console.log(list.value.Is);

    return {
      perpage,
      page,
      list,



    }

  },

  watch: {

    list: function (newValue, oldValue) {
      this.isLoading = false;
    },


    page: function (newValue, oldValue) {
      // 現在のページ番号が変化した時に実行される処理

      axios.post('/api/pagination', {
        newValue: newValue
      })
        .then(res => {


          this.list = res;


        })
        .catch(error => {
          console.log(error);
        });

    }


  }


}


</script>