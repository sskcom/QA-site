
<template>
  <div class="vl-parent">
    <loading v-model:active="isLoading" :can-cancel="true" :on-cancel="onCancel" :is-full-page="true">


      <video src="http://localhost:8081/video/Now-Loading.mp4"></video>

    </loading>



  </div>


  <v-toolbar title="サービス名">

    <v-text-field :loading="loading" density="compact" variant="solo" label="検索" append-inner-icon="mdi-magnify"
      single-line hide-details @click:append-inner="onClick"></v-text-field>

    <v-btn v-on:click="showContent">
      ボタン
    </v-btn>
  </v-toolbar>

  <div id="content" v-if="contentVisible"
    v-bind:style="{ backgroundColor: 'rgba(0, 0, 0, 0.3)', zIndex: 1, position: 'fixed', top: '0', left: '0', width: '100%', height: '100%' }">




    <div class="rounded-lg bg-white "
      v-bind:style="{ zIndex: 2, position: 'fixed', top: '50%', left: '50%', width: '85%', height: '85%', transform: 'translate(-50%, -50%)' }">


      <v-btn v-on:click="hiddenContent" v-bind:style="{ left: '80%' }">
        閉じる
      </v-btn>

      <v-btn v-bind:style="{ left: '80%' }">
        投稿する
      </v-btn>



      <v-text-field :loading="loading" density="compact" variant="solo" label="タイトル" append-inner-icon="mdi-magnify"
        single-line hide-details @click:append-inner="onClick"></v-text-field>
      <v-select v-model="value" :items="items" chips label="Chips" multiple></v-select>
      <div v-bind:style="{ height: '50%', overflow: 'auto' }">
        <!-- <ckeditor :editor= "editor" v-model="editorData" :config="editorConfig"></ckeditor> -->
        <QuillEditor :options="options" @blur="onEditorChange"/>
      </div>

    </div>

  </div>





  <v-card elevation="2" style="background-color: z-index: 0">



    <v-col cols="12" class="d-flex align-center " v-for="(item, index) in list.data.data.slice(0, 19)">



      <div class="flex flex-col w-full py-6 px-4 bg-white rounded-lg shadow-lg">
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



  <div>
    <v-pagination v-model="page" :length=list.data.last_page></v-pagination>

  </div>


</template>

<script >

import { ref } from 'vue'
import { useRoute, onBeforeRouteUpdate } from 'vue-router'
import axios from 'axios'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';


export default {
  name: 'Articles',



  data() {
    return {
      isLoading: true,
      contentVisible: false,

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
      
      items: ['PHP', 'HTML', 'Python', 'Ruby', 'Vue', 'JavaScript'],
      value: [],




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

    onEditorChange(editor) {
      // Do something with the changes made to the editor's contents
      console.log(editor)
    }
    

  },


  created() {


    axios.post('/api/pagination', {
      newValue: 1
    })
      .then(res => {

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

    console.log(list.value.Is);

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