
<template>



  <v-toolbar v-bind:style="{ position: 'relative',  }">

    <template v-slot:title>
      <div @click="home" v-bind:style="{
        
        position: 'fixed',
        left: '3%',
        top: '2%'
      }"
        class=" px-4 py-2   hover:bg-gray-300 focus:outline-none focus:shadow-outline">
        駆け出し部屋
      </div>
    </template>

    <!-- <v-btn v-on:click="home" v-bind:style="{ background: '#FFFBE5', position: 'fixed', left: '5%' ,width: '20%',height: '10%',fontSize:'30pt',
    padding: '12px 24px'}"
      class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline">
      サービス名
    </v-btn> -->


    <v-text-field :loading="loading" density="compact" label="検索" append-inner-icon="mdi-magnify" single-line
      hide-details @click:append-inner="onClick"
      v-bind:style="{ position: 'fixed', left: '40%', width: '40%' }"></v-text-field>
    <v-btn v-on:click="showContent" v-bind:style="{
      position: 'fixed',
      left: '83%',
      boxShadow: '0 2px 4px rgba(0, 0, 0, 0.2)',
      fontweight: '700',
    
    }" class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline">
      質問する
    </v-btn>


    <v-btn @click="account_menu = !account_menu" v-bind:style="{
      boxShadow: '0 2px 4px rgba(0, 0, 0, 0.2)',
      fontweight: '700'
       }"
      class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline">
      {{ state.user_info.username }}

    </v-btn>



  </v-toolbar>






  <v-container>
    <v-row>
      <v-col>
        <v-card>
          <v-card-title>質問タイトル </v-card-title>
          <v-card-title>{{ title }}</v-card-title>
          <v-card-subtitle>{{ categories }}</v-card-subtitle>
          <v-card-title>質問内容 </v-card-title>
          <v-card-text>




            <!-- <v-btn v-on:click="test" v-bind:style="{ background: '#FFFBE5' }"
              class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline">
              テストボタン
            </v-btn> -->
            <div ref="container">



              <template v-for="(item, index) in array">
                <template v-if="item.attributes === 'code'">
                  <div>
                    <div v-bind:style="{ overflow: 'auto' }">
                      <pre>

        <code  v-bind:class="{ ['language' + index]: true, ['islanguage' + index]: true }" ref="code_block" >{{ item.contents }}</code>
      </pre>
                    </div>
                  </div>
                </template>
                <template v-else>
                  <pre>
                  <component :is=item.attributes>{{ item.contents }}</component>
                </pre>
                </template>
              </template>

              <!-- <template v-for="(item, index) in array">
                <div v-show="item.attributes === 'code'">
                  <pre>
      <code v-bind:class="{ ['language' + index]: true, ['islanguage' + index]: true }" ref="codeBlockRefs + index" >{{ item.contents }}</code>
    </pre>
                </div>
                <pre v-show="item.attributes !== 'code'">
    <component :is=item.attributes>{{ item.contents }}</component>
  </pre>
              </template> -->




            </div>

          </v-card-text>

          <v-card>

            <v-card-title>回答</v-card-title>
          </v-card>

          <template v-for="(item, index) in array2">
            <template v-if="item.attributes === 'code'">
              <div>
                <div v-bind:style="{ overflow: 'auto' }">
                  <pre>

        <code v-bind:class="{ ['language' + index]: true, ['islanguage' + index]: true }" ref="codeBlockRefs + index" >{{ item.contents }}</code>
      </pre>
                </div>
              </div>
            </template>
            <template v-else>
              <pre>
                  <component :is=item.attributes>{{ item.contents }}</component>
                </pre>
            </template>
          </template>
          <v-btn @click="addanswer">回答する</v-btn>

          <QuillEditor :options="options" ref="answer" @blur="onEditorChange" />

        </v-card>
      </v-col>
    </v-row>
  </v-container>




  <div id="content" v-if="contentVisible"
    v-bind:style="{  zIndex: 1, position: 'fixed', top: '0', left: '0', width: '100%', height: '100%' }">




    <div class="rounded-lg"
      v-bind:style="{ zIndex: 2, position: 'fixed', top: '50%', left: '50%', width: '85%', height: '85%', transform: 'translate(-50%, -50%)', background: '#F9FBFE' }">


      <v-btn v-on:click="hiddenContent" v-bind:style="{ background: '#F9FBFE', left: '80%' }"
        class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline">
        閉じる
      </v-btn>

      <v-btn v-on:click="addanswer" v-bind:style="{ background: '#F9FBFE', left: '80%' }"
        class="mr-4 rounded-full px-4 py-2 text-gray-500  hover:bg-gray-300 focus:outline-none focus:shadow-outline">
        投稿する
      </v-btn>



      <v-text-field :loading="loading" density="compact" label="タイトル" append-inner-icon="mdi-magnify" single-line
        hide-details @click:append-inner="onClick" v-model="title"></v-text-field>
      <v-select class="custom-select" v-model="category" :items="items" chips label="カテゴリ" multiple>

      </v-select>
      <div v-bind:style="{ height: '50%', overflow: 'auto', background: '#F9FBFE' }">

        <QuillEditor :options="options" ref="answer" @blur="onEditorChange" />

      </div>

    </div>

  </div>





  <v-list v-if="account_menu" v-bind:style="{
    zindex: 2, position: 'fixed', left: '91%'
    , top: '8%', background: '#F9FBFE'
  }">



    <v-list-item @click="menu = false" v-bind:style="{ zindex: 2, background: '#F9FBFE' }">


      <v-list-item-title @click="profile" class="text-gray-600">ホーム</v-list-item-title>
    </v-list-item>

    <v-list-item @click="menu = false" v-bind:style="{ zindex: 2, background: '#F9FBFE' }">
      <v-list-item-title class="text-gray-600" @click="logout">ログアウト</v-list-item-title>
    </v-list-item>
    <v-list-item @click="menu = false" v-bind:style="{ zindex: 2, background: '#F9FBFE' }">
      <v-list-item-title class="text-gray-600">ヘルプ</v-list-item-title>
    </v-list-item>

  </v-list>




</template>


<style>
.v-input__control {
  background: #F9FBFE;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.ql-editor {
  background: '#F9FBFE';
}

.custom-select {
  background: '#F9FBFE';
}
</style>
<script >

import { ref } from 'vue'
import axios from 'axios'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { store } from './store/store';
import { useCookies } from 'vue3-cookies'

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
      modules: {
        syntax: true,
        toolbar: [{ 'header': 1 }, { 'header': 2 }, 'bold', 'italic', 'underline', 'code-block', 'image', 'video', { 'list': 'ordered' }, { 'list': 'bullet' }]

      },
      placeholder: 'xx',
      readOnly: false,
      theme: 'snow',


    },

    items: ['Babbage', 'Ballerina', 'Bash', 'D', 'Dart', 'Darwin', 'DataFlex', 'Ease', 'Easy PL/I', 'EASYTRIEVE PLUS', 'F#', 'Fortran', 'Go', 'Groovy', 'Haskell', 'Java', 'JavaScript', 'Julia', 'Kotlin', 'Lisp', 'Logo', 'Lua', 'MATLAB', 'Objective-C', 'OCaml', 'Pascal', 'Perl', 'PHP', 'Prolog', 'Python', 'R', 'Ruby', 'Rust', 'Scala', 'Swift', 'Visual Basic', 'Xojo'],
    category: [],
    title: '',

    array: [],
    categories: '',
    title: "",
    code: '',
    islanguage: '',

    array2: [],

    code_block: []



  }),
  mounted() {
    // this.state.$subscribe( () => {
    //   console.log("質問ID");
    //   console.log(this.state.questionState);

    // })

  },

  updated() {

    this.state.$subscribe(() => {
      console.log("質問ID");
      console.log(this.state.questionState);

    })


  },

  computed: {
    editor: {
      get() {
        return this.$refs.editor
      }

    },

    answer: {
      get() {
        return this.$refs.answer
      }

    },

    questionState() {
      return this.state.questionState;
    },

    // codeBlock: {
    //   get() {
    //     return this.$refs.code_block
    //   },
    //   set(newValue) {
    //     console.log(newValue)
    //   }


    // },

    codeBlock(){
      return this.$refs.code_block;
    },





    elementType(attributes) {
      const mapping = {
        p: 'p',
        h1: 'h1',
        h2: 'h2',
        h3: 'h3',
        h4: 'h4',
        h5: 'h5',
        h6: 'h6',
        // Add more mapping values as needed
      }
      return mapping[attributes] || 'p' // Default to 'p' element if no match is found
    }

  },
  components: {
    Loading,
    QuillEditor
  },

  methods: {

    home() {
      this.state.screenState = 4;
      this.state.screen_transition();
    },

    profile() {
      this.state.screenState = 6;
      this.state.screen_transition();
    },

    updateHighlight() {

      console.log("ゴリラ");
      console.log(this.$refs.code_block);

      for (let i = 0; i < this.$refs.code_block.length; i++) {
        console.log(this.$refs.code_block);
        console.log(this.$refs.code_block.length);

        const language = hljs.highlightAuto(this.$refs.code_block[i].innerText
        ).language;
        console.log(language);
        console.log("クラス");
        console.log(this.$refs.code_block[i]);
        this.$refs.code_block[i].classList = language;
        hljs.highlightElement(this.$refs.code_block[i]);
      }



    },

    setCookie() {
      this.setCookie('key', 'value', { expires: 1 })
    },

    getCookie() {
      console.log(this.cookies.key) // "value"
    },

    removeCookie() {
      this.removeCookie('key')
    },



    showContent() {
      this.contentVisible = true

    },
    hiddenContent() {
      this.contentVisible = false

    },

    editorContent() {
      function find_slice(str) {

        //改行文字で分割
        const lines = str.split('\n');


        const linse_size = lines.length;

        return lines[linse_size - 1];
      }


      //テキストエディタの入力データを整形
      function json_format_Data(data) {



        const edit_data = data;



        //配列のサイズを取得
        const edit_data_size = edit_data.length;



        const question_content_json = [];



        for (let i = 0; i < edit_data_size * 10; i++) {
          question_content_json.push({
            "attributes": "", "contents": ""
          });
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

                      question_content_json[i + j]["attributes"] = "p";
                      question_content_json[i + j]["contents"] = normal_insert_value[j];
                    }


                    //ヘッダーのテキストに当たる部分を取得
                    const insert_value = find_slice(edit_data[i]["insert"]);

                    question_content_json[i + linse_size - 1]["attributes"] = "h" + header_size;
                    question_content_json[i + linse_size - 1]["contents"] = insert_value;

                    i = i + linse_size - 1;

                    // 属性値がコードブロックだった場合
                  } else {
                    console.log("自分を愛していこう！");
                    //コードブロックのテキストに当たる部分を取得


                    const lines = edit_data[i]["insert"].split('\n');
                    const linse_size = lines.length;
                    const normal_insert_value = lines;


                    for (let j = 0; j <= linse_size - 2; j++) {

                      question_content_json[i + j]["attributes"] = "p";
                      question_content_json[i + j]["contents"] = normal_insert_value[j];
                    }


                    const code_insert_value = find_slice(edit_data[i]["insert"]);

                    question_content_json[i + linse_size - 1]["attributes"] = "code";
                    question_content_json[i + linse_size - 1]["contents"] = code_insert_value;

                    i = i + linse_size - 1;

                  }


                }



              }
              //ノーマルテキストだけの場合
            } else {
              const lines = edit_data[i]["insert"].split('\n');
              const linse_size = lines.length;
              const normal_insert_value = lines;


              for (let j = 0; j <= linse_size - 1; j++) {

                question_content_json[i + j]["attributes"] = "p";
                question_content_json[i + j]["contents"] = normal_insert_value[j];
              }

              i = i + linse_size

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


        const json = question_content_json.filter(obj => obj.attributes !== "" && obj.contents !== "");


        return json;


      }

      const edit_data = this.$refs.answer;


      const json = json_format_Data(edit_data);


      console.log(json);






      console.log("タイトル");
      console.log(this.title);

      console.log("カテゴリ");
      console.log(this.category);

      console.log("ユーザネーム");
      console.log(this.state.user_info.username);


      console.log(json);


      const title = this.title;

      const category = this.category.join(',');





      console.log(category);


      try {
        // POSTリクエストを送信
        const res = axios.post('/api/save_question', {

          title: title,

          category: category,

          questions: json,

          user_name: "田中太郎"

        });

        console.log(res);





      } catch (error) {
        // エラー処理
        // ...
      }







    },

    addanswer() {
      function find_slice(str) {

        //改行文字で分割
        const lines = str.split('\n');


        const linse_size = lines.length;

        return lines[linse_size - 1];
      }

      function space_fomat(str) {
        let strCopy = str;

        // Replace all line breaks with the string "\n"
        strCopy = strCopy.replace(/(?:\r\n|\r|\n)/g, '\\n');

        // Replace all whitespace characters with the string "\s"
        strCopy = strCopy.replace(/\s/g, '\\s');

        // Assign the modified string to the "contents" property
        return strCopy;
      }



      //テキストエディタの入力データを整形
      function json_format_Data(data) {



        const edit_data = data;



        //配列のサイズを取得
        const edit_data_size = edit_data.length;


        const question_content_json = [];



        for (let i = 0; i < edit_data_size * 10; i++) {
          question_content_json.push({
            "attributes": "", "contents": ""
          });
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

                      question_content_json[i + j]["attributes"] = "p";
                      question_content_json[i + j]["contents"] = normal_insert_value[j];
                    }


                    //ヘッダーのテキストに当たる部分を取得
                    const insert_value = find_slice(edit_data[i]["insert"]);

                    question_content_json[i + linse_size - 1]["attributes"] = "h" + header_size;
                    question_content_json[i + linse_size - 1]["contents"] = insert_value;

                    i = i + linse_size - 1;

                    // 属性値がコードブロックだった場合
                  } else {
                    console.log("自分を愛していこう！");
                    //コードブロックのテキストに当たる部分を取得


                    const lines = edit_data[i]["insert"].split('\n');
                    const linse_size = lines.length;
                    const normal_insert_value = lines;


                    for (let j = 0; j <= linse_size - 2; j++) {

                      question_content_json[i + j]["attributes"] = "p";
                      question_content_json[i + j]["contents"] = normal_insert_value[j];
                    }


                    const code_insert_value = find_slice(edit_data[i]["insert"]);

                    question_content_json[i + linse_size - 1]["attributes"] = "code";
                    question_content_json[i + linse_size - 1]["contents"] = space_fomat(code_insert_value);

                    i = i + linse_size - 1;

                  }


                }



              }
              //ノーマルテキストだけの場合
            } else {
              const lines = edit_data[i]["insert"].split('\n');
              const linse_size = lines.length;
              const normal_insert_value = lines;


              for (let j = 0; j <= linse_size - 1; j++) {

                question_content_json[i + j]["attributes"] = "p";
                question_content_json[i + j]["contents"] = normal_insert_value[j];
              }

              i = i + linse_size

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


        const json = question_content_json.filter(obj => obj.attributes !== "" && obj.contents !== "");


        return json;


      }


      var data = this.answer.getContents();

      console.log("やっほー");



      const json = json_format_Data(data.ops);

      console.log("今回のjsonは");
      console.log(json);

      var array = json

      let mergedCode = "";
      let mergedArray = [];
      for (let i = 0; i < array.length; i++) {
        if (array[i].attributes === "code") {
          mergedCode += "\n" + array[i].contents;
        } else {
          if (mergedCode !== "") {
            mergedArray.push({ contents: mergedCode + "\n", attributes: "code" });
            mergedCode = "";
          }
          mergedArray.push(array[i]);
        }
      }
      if (mergedCode !== "") {
        mergedArray.push({ contents: mergedCode + "\n", attributes: "code" });
      }

      this.array2 = mergedArray;

      // try {
      //   // POSTリクエストを送信
      //   const res = axios.post('/api/save_question', {

      //     title: title,

      //     category: category,

      //     questions: json,

      //     user_name: "田中太郎"

      //   });

      //   console.log(res);





      // } catch (error) {
      //   // エラー処�?
      //   // ...
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

    hljs.highlightAll();

    const state = store();
    state.screen_transition();





    axios.post('/api/send_question', {
      questions_id: state.questionState,
    })
      .then(res => {

        function remove(str, remove) {
          return str.replace(remove, '');
        }

        console.log(res);

        console.log(typeof (res.data.question_data.content));



        this.categories = res.data.question_data.category;

        this.title = res.data.question_data.title;

        const data = res.data.question_data.content;

        const json = JSON.parse(data);

        console.log(json);



        this.array = json;

        const array = this.array;

        const indices = array.map((entry, index) => {
          if (entry.attributes === 'code') {
            return index;
          }
        }).filter(index => index !== undefined);

        console.log("インデックス");
        console.log(indices);




        let mergedCode = "";
        let mergedArray = [];
        for (let i = 0; i < array.length; i++) {
          if (array[i].attributes === "code") {
            mergedCode += "\n" + array[i].contents;
          } else {
            if (mergedCode !== "") {
              mergedArray.push({ contents: mergedCode + "\n", attributes: "code" });
              mergedCode = "";
            }
            mergedArray.push(array[i]);
          }
        }
        if (mergedCode !== "") {
          // Replace all instances of "\s" with a space
          mergedCode = mergedCode.replace(/\\s/g, " ");
          mergedArray.push({ contents: mergedCode + "\n", attributes: "code" });
        }










        this.array = mergedArray;

        console.log(mergedArray);


      })
      .catch(error => {
        console.log(error);
      })


  },
  setup() {
    const { cookies } = useCookies();
    return { cookies };

   
  },


  watch: {

    // codeBlock: {
    //   handler(newValue, oldValue) {

    //     console.log("ref が変更されたよ")
    //     console.log(newValue, oldValue)
    //   },
    //   deep: true
    // },

  // },

    codeBlock(){
      console.log("ref が変更されたよ")
      console.log(this.$refs.code_block);
    },
    

    questionState() {
      console.log("変更されたよ");
      console.log(this.state.questionState);

      console.log("オブジェクト");
      console.log(this.state.question);


      this.categories = this.state.question.category;

      this.title = this.state.question.title;

      const data = this.state.question.content;

      const json = JSON.parse(data);

      console.log(json);



      this.array = json;

      const array = this.array;

      const indices = array.map((entry, index) => {
        if (entry.attributes === 'code') {
          return index;
        }
      }).filter(index => index !== undefined);

      console.log("インデックス");
      console.log(indices);




      let mergedCode = "";
      let mergedArray = [];
      for (let i = 0; i < array.length; i++) {
        if (array[i].attributes === "code") {
          mergedCode += "\n" + array[i].contents;
        } else {
          if (mergedCode !== "") {
            mergedArray.push({ contents: mergedCode + "\n", attributes: "code" });
            mergedCode = "";
          }
          mergedArray.push(array[i]);
        }
      }
      if (mergedCode !== "") {
        // Replace all instances of "\s" with a space
        mergedCode = mergedCode.replace(/\\s/g, " ");
        mergedArray.push({ contents: mergedCode + "\n", attributes: "code" });
      }










      this.array = mergedArray;

      console.log(mergedArray);

      // axios.post('/api/send_question', {
      //   questions_id: this.state.questionState,
      // })
      //   .then(res => {

      //     function remove(str, remove) {
      //       return str.replace(remove, '');
      //     }

      //     console.log(res);

      //     console.log(typeof (res.data.question_data.content));



      //     this.categories = res.data.question_data.category;

      //     this.title = res.data.question_data.title;

      //     const data = res.data.question_data.content;

      //     const json = JSON.parse(data);

      //     console.log(json);



      //     this.array = json;

      //     const array = this.array;

      //     const indices = array.map((entry, index) => {
      //       if (entry.attributes === 'code') {
      //         return index;
      //       }
      //     }).filter(index => index !== undefined);

      //     console.log("インデックス");
      //     console.log(indices);




      //     let mergedCode = "";
      //     let mergedArray = [];
      //     for (let i = 0; i < array.length; i++) {
      //       if (array[i].attributes === "code") {
      //         mergedCode += "\n" + array[i].contents;
      //       } else {
      //         if (mergedCode !== "") {
      //           mergedArray.push({ contents: mergedCode + "\n", attributes: "code" });
      //           mergedCode = "";
      //         }
      //         mergedArray.push(array[i]);
      //       }
      //     }
      //     if (mergedCode !== "") {
      //       // Replace all instances of "\s" with a space
      //       mergedCode = mergedCode.replace(/\\s/g, " ");
      //       mergedArray.push({ contents: mergedCode + "\n", attributes: "code" });
      //     }










      //     this.array = mergedArray;

      //     console.log(mergedArray);


      //   })
      //   .catch(error => {
      //     console.log(error);
      //   });
    }





  }


}


</script>