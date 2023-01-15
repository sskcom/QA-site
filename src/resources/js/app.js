import { createApp } from "vue";
import App from "./components/App.vue";
import Answer from "./components/answer.vue";
import Register from "./components/Register.vue";
import Login from "./components/Login.vue";
import Profile from "./components/Profile.vue"; 
import index from "./components/index.vue";



import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { createPinia } from 'pinia'



const vuetify = createVuetify({
  components,
  directives,
})

const pinia = createPinia()

createApp(App).use(pinia).use(vuetify).mount("#app");

createApp(Answer).use(pinia).use(vuetify).mount("#answer");

createApp(Register).use(pinia).use(vuetify).mount("#register");
createApp(Login).use(pinia).use(vuetify).mount("#login");

createApp(Profile).use(pinia).use(vuetify).mount("#profile");

createApp(index).use(pinia).use(vuetify).mount("#index");
