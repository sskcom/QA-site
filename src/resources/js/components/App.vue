
<template>
  <div class="vl-parent">
    <loading v-model:active="isLoading" :can-cancel="true" :on-cancel="onCancel" :is-full-page="true">


      <video src="http://localhost:8081/video/Now-Loading.mp4"></video>

    </loading>



  </div>


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

    <v-text-field :loading="loading" density="compact" label="検索" append-inner-icon="mdi-magnify" single-line
      hide-details @click:append-inner="onClick"
      v-bind:style="{ 
        position: 'fixed', 
        left: '40%', 
        width: '40%', 
    
    }"></v-text-field>
    <v-btn v-on:click="showContent" v-bind:style="{
      position: 'fixed',
      left: '83%',
      boxShadow: '0 2px 4px rgba(0, 0, 0, 0.2)',
      fontweight: '700',
    
    }">
      質問する
    </v-btn>


    <v-btn @click="account_menu = !account_menu" v-bind:style="{ 
      boxShadow: '0 2px 4px rgba(0, 0, 0, 0.2)',
      fontweight: '700',
     }"
      class="mr-4 rounded-full px-4 py-2   hover:bg-gray-300 focus:outline-none focus:shadow-outline">
      {{ state.user_info.username }}

    </v-btn>



  </v-toolbar>








  <div id="content" v-if="contentVisible"
    v-bind:style="{ zIndex: 1, position: 'fixed', top: '0', left: '0', width: '100%', height: '100%' }">




    <div class="rounded-lg"
      v-bind:style="{ zIndex: 2, position: 'fixed', top: '50%', left: '50%', width: '85%', height: '85%', transform: 'translate(-50%, -50%)', background: '#F9FBFE' }">


      <v-btn v-on:click="hiddenContent" v-bind:style="{ background: '#F9FBFE', left: '80%' }"
        class="mr-4 rounded-full px-4 py-2   hover:bg-gray-300 focus:outline-none focus:shadow-outline">
        閉じる
      </v-btn>

      <v-btn v-on:click="editorContent" v-bind:style="{ background: '#F9FBFE', left: '80%' }"
        class="mr-4 rounded-full px-4 py-2   hover:bg-gray-300 focus:outline-none focus:shadow-outline">
        投稿する
      </v-btn>



      <v-text-field :loading="loading" density="compact" label="タイトル" append-inner-icon="mdi-magnify" single-line
        hide-details @click:append-inner="onClick" v-model="title"></v-text-field>
      <v-select class="custom-select" v-model="category" :items="items" chips label="カテゴリ" multiple>

      </v-select>
      <div v-bind:style="{ height: '50%', overflow: 'auto', background: '#F9FBFE' }">

        <QuillEditor :options="options" ref="editor" @blur="onEditorChange" />
      </div>

    </div>

  </div>



  <!-- 質問一覧画面 -->
  <v-card elevation="2" v-bind:style="{ position: 'relative', zindex: 0 }">



    <v-col cols="12" class="d-flex align-center soft-gloss2" v-for="(item, index) in list.data.data.slice(0, 19)"
      v-bind:style="{ zindex: 0, background: '#F9FBFE' }">



      <div ref="answerButton" @click="goToAnswer(index)" :id="item.id" class="flex flex-col w-full py-6 px-4  "
      v-bind:style="{
          boxShadow: '0 2px 4px rgba(0, 0, 0, 0.2)',
          background: '#F9FBFE',
          fontWeight: '900',
          color: '#2B546A',
          // textShadow: '1px 1px 1px rgba(0, 0, 0, 0.5)',
          border: '1px solid ',
          borderRadius: '15px'
        }">
        <div class="flex items-center py-2">
        </div>
        <div class="py-2">
          <h2 v-bind:style="{ fontSize: '20px' }">{{ item.title }}</h2>
        </div>
        <div class="flex items-center py-2">
          <p class=" mr-4">{{ item.tag }}</p>
          <p class=" mr-4">回答数: {{ item.answer_count }}</p>
          <p class=" mr-4">解決済み: {{ item.is_soved }}</p>
        </div>
        <div class="flex items-center py-2">
          <p class=" mr-4">投稿者: {{ item.user_name }}</p>
          <p class=" mr-4">閲覧数: {{ item.view_count }}</p>

        </div>
      </div>


    </v-col>

  </v-card>

  <v-list v-if="account_menu" v-bind:style="{
    zindex: 2, position: 'fixed', left: '91%'
    , top: '8%', background: '#F9FBFE'
  }">
    <!-- <v-list-item v-for="item in it" :key="item.title" @click="menu = false" v-bind:style="{zindex:2}"

                
                > -->


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

  <div>
    <v-pagination v-model="page" :length=list.data.last_page></v-pagination>

  </div>


</template>


<style>
.v-input__control {
  background: #F9FBFE;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.ql-editor {
  background: '#F9FBFE'
}

v-btn {
  background: 'F9FBFE';
  box-shadow: 0 2px 4px rgba(172, 20, 20, 0.2);


}

.custom-select {
  background: #F9FBFE;
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
      { title: 'ホーム?' },
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
    category: [],
    title: '',





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


    profile() {
      this.state.screenState = 6;
      this.account_menu = false;
      this.state.screen_transition();
    },


    goToAnswer(index) {




      console.log(index);


      console.log("ここでlistを入れます" + this.list);
      this.state.question = this.list.data.data[index];
      console.log("入れた値" + this.state.question);

      this.state.screenState = 5;

      console.log(this.$refs.answerButton[index].id);
      console.log("このid入れます" + this.$refs.answerButton.id);
      this.state.questionState = this.$refs.answerButton[index].id;
      // this.state.screen_transition();


      // setTimeout(() => {
      this.account_menu = false;
      this.state.screen_transition();
      // }, 2500) // 1秒後に処理を実行

    },

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



      //配�?��?�サイズを取�?
      const edit_data_size = edit_data.length;

      console.log("配�?��?�サイズ:" + edit_data_size);

      const question_content_json = [];



      for (let i = 0; i < edit_data_size * 10; i++) {
        question_content_json.push({
          "attributes": "", "contents": ""
        });
      }


      console.log(question_content_json);




      //タイトルの取�?
      //カ�?ゴリの取�?
      //ユーザ名�?�取�?



      function find_slice(str) {

        //改行文字で�?割
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



      //新�?
      for (let i = 0; i < edit_data_size; i++) {
        console.log(i);
        console.log("今日も一日頑張ろう?�?");
        //ノ�?�マル�?キスト�?�処�?
        //現要�?が属性値でなかった�?��?
        if (!edit_data[i].hasOwnProperty("attributes")) {
          console.log("明日も�??気に�?こう?�?");


          //次の要�?が存在しなかった�?��?
          if (!(edit_data[i + 1] == undefined)) {

            console.log("レ�?�?ラゴー");
            //次の要�?に属性値がなかった�?��?
            if (!edit_data[i + 1].hasOwnProperty("attributes")) {
              //全�?字�?�をjsonに格�?
              console.log("希望を持って�?こう?�?");
              question_content_json[i]["attributes"] = "p";
              question_content_json[i]["contents"] = edit_data[i]["insert"];


              //次の要�?が存在する場�?
            } else {
              console.log("自�?を信じて�?こう?�?");
              //次の要�?が存在するかど�?�?

              //次の要�?が�?飾�?字�?�場合　ノ�?�マル�?キスト�?�場合�?�処�?
              if (edit_data[i + 1].attributes.hasOwnProperty("bold") || edit_data[i + 1].attributes.hasOwnProperty("underline") || edit_data[i + 1].attributes.hasOwnProperty("italic")) {

                console.log("自�?で選んだ道を進んで�?こう?�?");


                if (edit_data[i]["insert"].indexOf("'\n'") === -1) { //改行文字が踏まれな�?場�?
                  console.log("目標を持って�?こう?�?");

                  //全�?字�?�をjsonに格�?
                  question_content_json[i]["attributes"] = "p";
                  question_content_json[i]["contents"] = edit_data[i]["insert"];

                } else { //改行文字が踏まれる場�?
                  console.log("一歩一歩前に進んで�?こう?�?");




                  //改行文字で�?割
                  const lines = edit_data[i]["insert"].split('\n');


                  const linse_size = lines.length;


                  //行ごとに�?番にjosnに値を�?��?
                  for (let j = 0; j < linse_size; j++) {
                    question_content_json[i + j]["attributes"] = "p";
                    question_content_json[i + j]["contents"] = lines[j];

                  }



                }


              }
              //次の要�?の属性が�?飾�?字じ�?なかった�?��?(属性値が�?�ッダーかコー�?)
              else {
                console.log("自�?らしさを大�?にしよ�??�?");
                // 属性値が�?�ッダー�?った�?��?
                if (edit_data[i + 1].attributes.hasOwnProperty("header")) {
                  //ヘッダーのサイズを判断
                  console.log("今を大�?に生きよう?�?");


                  const header_size = edit_data[i + 1].attributes.header;


                  const lines = edit_data[i]["insert"].split('\n');
                  const linse_size = lines.length;
                  const normal_insert_value = lines;


                  for (let j = 0; j <= linse_size - 2; j++) {

                    question_content_json[i + j]["attributes"] = "p";
                    question_content_json[i + j]["contents"] = normal_insert_value[j];
                  }


                  //ヘッダーの�?キストに当たる部�?を取�?
                  const insert_value = find_slice(edit_data[i]["insert"]);

                  question_content_json[i + linse_size - 1]["attributes"] = "h" + header_size;
                  question_content_json[i + linse_size - 1]["contents"] = insert_value;

                  i = i + linse_size - 1;

                  // 属性値がコードブロ�?ク�?った�?��?
                } else {
                  console.log("自�?を�?�して�?こう?�?");
                  //コードブロ�?クの�?キストに当たる部�?を取�?


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
            //ノ�?�マル�?キストだけ�?�場�?
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

          //現要�?が属性値�?った�?��?
        } else {
          console.log("周り�?�人を思い�?ろう?�?");
          //�?飾�?字だった�?��?
          if (edit_data[i].attributes.hasOwnProperty("bold") || edit_data[i].attributes.hasOwnProperty("underline") || edit_data[i].attributes.hasOwnProperty("italic")) {
            console.log("幸せを見つけよ�??�?");
            //次の要�?が属性値�?った�?��?
            if (!(edit_data[i + 1].attributes == undefined)) {
              //次の要�?の属性値が�?�ッダー�?った�?��?
              console.log("小さな喜�?�を大�?にしよ�??�?");
              if (edit_data[i + 1].attributes.hasOwnProperty("header")) {
                //ヘッダーのサイズを判断
                console.log("感謝を忘れずに�?こう?�?");
                const header_size = edit_data[i + 1].attributes.header;


                //�?飾�?字が太字だった�?��?
                if (edit_data[i].attributes.hasOwnProperty("bold")) {
                  console.log("今日も笑顔で�?こう?�?");
                  question_content_json[i]["attributes"] = "h" + header_size + ",b";
                  question_content_json[i]["contents"] = edit_data[i].insert;

                }

                //�?飾�?字がアンダーライン�?ったっ場�?
                else if (edit_data[i].attributes.hasOwnProperty("underline")) {
                  console.log("前向きに�?えよ�??�?");
                  question_content_json[i]["attributes"] = "h" + header_size + ",u";
                  question_content_json[i]["contents"] = edit_data[i].insert;


                  //�?飾�?字が斜体文字だった�?��?
                } else {
                  console.log("問題を解決するために努力しよう?�?");
                  question_content_json[i]["attributes"] = "h" + header_size + ",i";
                  question_content_json[i]["contents"] = edit_data[i].insert;

                }

                i++;


                //次の要�?が�?飾�?字だった�?��?
              }


            } else {

              //�?飾�?字が太字だった�?��?
              if (edit_data[i].attributes.hasOwnProperty("bold")) {
                console.log("新しいことに挑戦しよ�??�?");
                question_content_json[i]["attributes"] = "b";
                question_content_json[i]["contents"] = edit_data[i].insert;

              }

              //�?飾�?字がアンダーライン�?ったっ場�?
              else if (edit_data[i].attributes.hasOwnProperty("underline")) {
                console.log("今日も一日を大�?に生きよう?�?");
                question_content_json[i]["attributes"] = "u";
                question_content_json[i]["contents"] = edit_data[i].insert;


                //�?飾�?字が斜体文字だった�?��?
              } else {
                console.log("周り�?�人たちと感謝を交わそ�?");
                question_content_json[i]["attributes"] = "i";
                question_content_json[i]["contents"] = edit_data[i].insert;

              }
            }




          }



        }


      }


      const json = question_content_json.filter(obj => obj.attributes !== "" && obj.contents !== "");

      // const json = JSON.stringify(array);

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
        // エラー処�?
        // ...
      }




      axios.post('/api/pagination', {
        newValue: this.page.value,
      })
        .then(res => {

          console.log("こんにちは");
          console.log(res);
          this.list = res;


        })
        .catch(error => {
          console.log(error);
        });



    },

    async logout() {
      try {
        // ログアウトをリクエス�?
        const res = await axios.post('/api/logout');

        console.log(res);
        // ログアウトに成功した場合、ユーザ�?報をリセ�?�?
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
    state.screen_transition();

    axios.post('/api/pagination', {
      newValue: 1
    })
      .then(res => {

        console.log("こんにちは");
        console.log(res);
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
      // 現在のペ�?�ジ番号が変化した時に実行される処�?



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