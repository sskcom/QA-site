
<template>
  <div class="vl-parent">
    <loading v-model:active="isLoading" :can-cancel="true" :on-cancel="onCancel" :is-full-page="true">
    
      
          <video src="http://localhost:8081/video/Now-Loading.mp4"></video>
  
    </loading>

  </div>

  <v-card elevation="2">

<v-col cols="12" class="d-flex align-center " v-for="(item, index) in list.data.data.slice(0, 19)">

  <div
    class="flex flex-col items-center w-full md:w-1/2 lg:w-1/3 px-4 py-6 bg-gray-100 rounded-lg shadow-lg border-blue-500">
    <h2 class="text-2xl font-bold text-gray-800">{{ item.title }}</h2>
    <p class="text-gray-600">{{ item.tag }}</p>
    <p class="text-gray-600">回答数: {{ item.answer_count }}</p>
    <p class="text-gray-600">解決済み: {{ item.is_soved }}</p>
    <p class="text-gray-600">投稿者: {{ item.user_name }}</p>
    <p class="text-gray-600">閲覧数: {{ item.view_counst }}</p>
  </div>

</v-col>

</v-card>

<div>
<v-pagination v-model="page" :length=list.data.last_page></v-pagination>
</div>

</template>

<script>

import { ref } from 'vue'
import { useRoute, onBeforeRouteUpdate } from 'vue-router'
import axios from 'axios'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';

export default {
  name: 'Articles',


  data() {
    return {
      isLoading: true,
    }
  },
  components: {
    Loading
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

    list: function(newValue, oldValue){
        this.isLoading=false;
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