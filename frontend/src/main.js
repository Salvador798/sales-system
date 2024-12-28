import { createApp } from "vue";
import "./assets/css/styles.css";
import "./assets/js/script";
import "https://use.fontawesome.com/releases/v6.3.0/js/all.js";
import "https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js";
import router from "./router";
import App from "./App.vue";

createApp(App).use(router).mount("#app");
