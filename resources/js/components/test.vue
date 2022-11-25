<template>
    <div class="nav">
        <ul  class="d-flex; justify-content-between w-100">
            <li v-for="link in authLinks" :class="{ 'active': (link.id === id)}">
                <router-link :to='link.href' @click="show(link.id)">
                    <p @click="show(link.id)">{{link.title}} </p>
                </router-link>
            </li>
            <li style="color: white"><button class="logout-btn" @click="logout()">logout</button></li>
        </ul>
        <ul >
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

export default {
    name: "test",
    data(){
        return{
            links:[
                {id: 1, title: 'About', href:'/about'},
                {id: 2, title: 'Register', href:'/'},
                {id: 3,title: 'Login', href:'/login'}
            ],
            authLinks: [
                {id: 2,title: 'Chat', href:'/video-chat'},
                // {id: 3,title: 'logout', href:'/'},
            ],
            userId:'',
            id:1,
        }
    },
    // watch:{
    //     getUser(newValue, old){
    //         // if (this.token!=null){
    //             this.authUser()
    //         // }
    //     }
    // },
    // computed:{
    //     getUser(){
    //         return this.userId
    //     }
    // },
    created() {
        // if(this.userId){
            this.authUser()
        // }
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
