<template>
    <div class="nav">

        <ul v-if="userId === null">
            <li v-for="link in links">
                <router-link :to='link.href' :class="{ 'active': (link.id === id)}" >
                   <p @click="show(link.id)">{{link.title}} </p>
                </router-link>
            </li>

        </ul>
        <ul v-else class="d-flex; justify-content-between w-100">
            <li v-for="link in authLinks" :class="{ 'active': (link.id === id)}">
                <router-link :to='link.href' @click="show(link.id)">
                    <p @click="show(link.id)">{{link.title}} </p>
                </router-link>
            </li>
            <li><p style="color: white">{{user.email}}</p> </li>
            <li style="color:white">
            </li>
            <li style="color: white"><button class="logout-btn" @click="logout()">logout</button></li>
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
            userId:null,
            id:1,
            user:{}
        }
    },
    watch: {
        userIdGet(newValue, old){
                this.authUser()
        }
    },
    created() {
        if(localStorage.getItem('access_token')){
            this.authUser()
        }
    },
    computed:{
      userIdGet(){
          return this.userId
        }
    },
    methods:{
        logout(){
            axios.get('/api/logout').then( result => {
                localStorage.removeItem('access_token');
                this.userId=null
                this.user={}
                this.$router.push({path: "/"});
                console.log(this.userId)
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
                console.log(this.userId)

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
