import { defineStore } from "pinia";

export const store = defineStore("auth", {
    state: () => ({


      user_info:{
        
            username: "",
            email: "",
            hash: "",

      },
        
        screenState: 1,
    }),
    actions: {
        login(username, email, hash) {
            this.user_info.username = username;
            this.user_info.email = email;
            this.user_info.hash = hash;

          
        },
        logout() {
            this.user_info.username = "";
            this.user_info.email = "";
            this.user_info.hash = "";
        },

        screen_transition() {
            const app_element = document.getElementById("app");
            const register_element = document.getElementById("register");
            const login_element = document.getElementById("login");
            const index_element = document.getElementById("index");
            switch (this.screenState) {
                case 1: //ホーム画面
                    app_element.className = "hidden";
                    register_element.className = "hidden";
                    login_element.className = "hidden";
                    index_element.className = "show";

                    break;

                case 2: //登録画面
                    app_element.className = "hidden";
                    register_element.className = "show";
                    login_element.className = "hidden";
                    index_element.className = "hidden";
                    break;

                case 3: //ログイン画面

                app_element.className = "hidden";
                register_element.className = "hidden";
                login_element.className = "show";
                index_element.className = "hidden";
                    break;

                case 4: //質問一覧画面
                app_element.className = "show";
                register_element.className = "hidden";
                login_element.className = "hidden";
                index_element.className = "hidden";
                    break;
            }
        },
    },
});
