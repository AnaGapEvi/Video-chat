<template>
    <div class="cont">
        <div class="login">
            <h2>Sign in</h2>
            <form @submit.prevent="loginAuth()">
                <input type="email" v-model="form.email" placeholder="test@gmail.com"/>
                <input type="password" v-model="form.password" placeholder="***********" />
                <button>Sign in</button>
            </form>
            {{error}}
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Login",
    data(){
        return{
            form:{
                email:'',
                password:''
            },
            error:'',
            token:null
        }
    },
    methods: {
        loginAuth() {
            axios.post('/api/login', this.form)
                .then(resp => {
                    // axios.defaults.headers.common['Authorization'] = 'Bearer ' + resp.data.token;
                    localStorage.setItem('access_token', resp.data.token);
                    this.token = resp.data.token
                    this.$router.push({path: '/container'})
                    window.location.reload()
                }).catch( error => {
                this.error=error.response.data.message
            })
        }
    }
}
</script>

<style scoped>
.login h2{
    text-align: center;
}
.login{
    width: 500px;
    position: absolute;
    left: 50%;
    top:50%;
    transform: translate(-50%, -50%);
    color:white;
    padding: 20px 40px;
}
.login form button{
    margin:20px;
    background: rgba(255, 255, 255, 0.56);
    padding: 7px 20px;
    border-radius:50px;
    color: white;
}
.login form input{
    display:block;
    margin: 20px;
    width: 90%;
    padding: 7px 20px;
    border-radius:50px
}
.cont{
    width: 100%;
    height: 100vh;
    background-image: url("https://media.istockphoto.com/id/643282534/video/using-laptop-late-in-night.jpg?s=640x640&k=20&c=ktoMKgkCZ31ABkMz3c9ARETQjrGyyCtxSFQ8NPD1ZAc=");
    background-size: 100% 100%;
}
</style>
