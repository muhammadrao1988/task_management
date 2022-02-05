require("./bootstrap");

window.Vue = require("vue");

// Register our components
Vue.component("task-board", require("./components/TaskBoard.vue").default);
Vue.component("task-detail", require("./components/ViewTaskForm.vue").default);

const app = new Vue({
    el: "#app"
});