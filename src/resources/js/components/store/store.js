import { defineStore } from "pinia";

// Cookies.set('test', 'Hello',{expires: 1})
// function alertCookieValue() {
//   alert(Cookies.get('sereenState'))
//   // => Hello
// }

// alertCookieValue();

export const store = defineStore("auth", {
    state: () => ({
        user_info: {
            username: (Cookies.get('username')),
            email: (Cookies.get('email')),
            hash: (Cookies.get('hash')),
        },

        screenState: Number(Cookies.get('sereenState')),

        questionState: Number(Cookies.get('questionState')),

        question:"",
    }),
    actions: {
        login(username, email, hash) {
            this.user_info.username = username;
            this.user_info.email = email;
            this.user_info.hash = hash;

            Cookies.set('username', this.user_info.username,{expires: 1});
            Cookies.set('email', this.user_info.email,{expires: 1});
            Cookies.set('hash', this.user_info.hash,{expires: 1});
        },
        logout() {
            this.user_info.username = "";
            this.user_info.email = "";
            this.user_info.hash = "";

            Cookies.set('username', this.user_info.username,{expires: 1});
            Cookies.set('email', this.user_info.email,{expires: 1});
            Cookies.set('hash', this.user_info.hash,{expires: 1});
        },

        screen_transition() {
            const app_element = document.getElementById("app");
            const register_element = document.getElementById("register");
            const login_element = document.getElementById("login");
            const profile_element = document.getElementById("profile");
            const answer_element = document.getElementById("answer");
            const index_element = document.getElementById("index");

            Cookies.set('sereenState', this.screenState,{expires: 1})
            Cookies.set('questionState', this.questionState,{expires: 1})

            console.log("これが実際に使用されている値です");
            console.log(this.screenState);
            console.log("これが実際に使用されている型名です");
            console.log(typeof(this.screenState));
            
            switch (this.screenState) {
                case 1: //ホーム画面
                    app_element.className = "hidden";
                    register_element.className = "hidden";
                    login_element.className = "hidden";
                    profile_element.className = "hidden";
                    answer_element.className = "hidden";
                    index_element.className = "show";

                    break;

                case 2: //登録画面
                    app_element.className = "hidden";
                    register_element.className = "show";
                    login_element.className = "hidden";
                    profile_element.className = "hidden";
                    answer_element.className = "hidden";
                    index_element.className = "hidden";
                    break;

                case 3: //ログイン画面
                    app_element.className = "hidden";
                    register_element.className = "hidden";
                    login_element.className = "show";
                    profile_element.className = "hidden";
                    answer_element.className = "hidden";
                    index_element.className = "hidden";
                    break;

                case 4: //質問一覧画面
                console.log("ゴリラ");
                    app_element.className = "show";
                    register_element.className = "hidden";
                    login_element.className = "hidden";
                    profile_element.className = "hidden";
                    answer_element.className = "hidden";
                    index_element.className = "hidden";
                    break;
                case 5: //質問一覧画面
                    app_element.className = "hidden";
                    register_element.className = "hidden";
                    login_element.className = "hidden";
                    profile_element.className = "hidden";
                    answer_element.className = "show";
                    index_element.className = "hidden";
                    break;

                case 6: //質問一覧画面
                    app_element.className = "hidden";
                    register_element.className = "hidden";
                    login_element.className = "hidden";
                    profile_element.className = "show";
                    answer_element.className = "hidden";
                    index_element.className = "hidden";
                    break;
            }
        },
    },
});
