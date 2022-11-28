import  vueRouter from "vue-router";
import Vue from 'vue'

import test from "./components/test.vue";
import home from "./components/home.vue";
import about from "./components/about.vue";
import Registration from "./components/auth/Registration.vue";
import Login from "./components/auth/Login.vue";
import VideoChat from "./components/auth/VideoChat.vue";
import Container from "./components/chat/Container.vue"
import VideoApp from "./components/videoApp.vue";
import TwilioChat from "./components/TwilioChat.vue";
Vue.use(vueRouter);

const routes = [
    {path: '/about', component: about},
    {path: '/home', component: home},
    {path: '/', component: Registration},
    {path: '/login', component: Login},
    {path: '/video-chat', component: VideoChat},
    {path: '/container', component: Container},
    {path: '/video', component: VideoApp},
    {path: '/twilio-chat', component: TwilioChat}
]

export default  new  vueRouter({
    mode: "history",
    routes
})
