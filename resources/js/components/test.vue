<template>
    <div class="nav">
        <ul v-if="userId !== ''" class="d-flex; justify-content-between w-100">
            <li v-for="link in authLinks" :class="{ 'active': (link.id === id)}">
                <router-link :to='link.href' @click="show(link.id)">
                    <p @click="show(link.id)">{{link.title}} </p>
                </router-link>
            </li>
            <li><p style="color: white">{{user.email}} {{user.id}}</p> </li>
            <li style="color:white">
            </li>
            <li style="color: white"><button class="logout-btn" @click="logout()">logout</button></li>
        </ul>
        <ul v-else>
            <li v-for="link in links">
                <router-link :to='link.href' :class="{ 'active': (link.id === id)}" >
                   <p @click="show(link.id)">{{link.title}} </p>
                </router-link>
            </li>

        </ul>
    </div>
</template>

<script>
import axios from "axios";
import About from "./about.vue";

export default {
    name: "test",
    components: {About},
    data(){
        return{
            links:[
                {id: 2, title: 'Register', href:'/'},
                {id: 3,title: 'Login', href:'/login'}
            ],
            authLinks: [
                {id: 2,title: 'Chat', href:'/container'},
                {id: 3,title: 'Video', href:'/about'},
                {id: 3,title: 'OtherVideo', href:'/video'},
            ],
            userId:'',
            id:1,
            user:{}
        }
    },
    created() {
            this.authUser()
    },
    methods:{
        logout(){
            axios.get('/api/logout').then( result => {
                localStorage.removeItem('access_token');
                this.userId=null
                this.$router.push({path: "/"});
            }).catch(error => {
                return error
            })
        },
        show(id){
            if(this.id===id){
                this.id = ''
            } else {
                this.id=id
            }
        },
        authUser() {
            axios.get('/api/auth-user').then(response => {
                this.userId = response.data.user.id
                this.user = response.data.user
            }).catch(error => {
                this.error = error.response.data.error
            })
        },
    }
}
</script>

<style scoped>
p{
    margin: 0!important;
    padding: 0!important;
}
.nav{
    background: black;
    text-align: center;
    margin: 0!important;
    padding: 15px;
}
ul {
    display: flex;
    align-items:center;
    list-style:none
}
ul li a{
    color: white;
    font-weight: 600;
    text-decoration: none;
}
ul li{
    margin: 0 15px
}
.active{
    color: lightskyblue;
}
.logout-btn{
    color:white;
    background: none;
    border:none
}
</style>
