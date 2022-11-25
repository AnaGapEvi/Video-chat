<template>
    <div class="cont">
        <div class="register">
            <h2>Sign up</h2>
            <form @submit.prevent="registerAuth()">
                <input type="text" v-model="form.name" autocomplete="off" placeholder="name..."/>
                <span>{{errors.errorName}}</span>
                <input type="email" v-model="form.email" autocomplete="off" placeholder="test@gmail.com"/>
                <span>{{errors.errorEmail}}</span>

                <input type="password" v-model="form.password" autocomplete="off" placeholder="********"/>
                <span>{{errors.errorPassword}}</span>
                <button>Sign up</button>
            </form>
            {{error}}
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "Registration",
    data(){
        return{
            form:{
                name:'',
                email:'',
                password:''
            },
            errors: {},
            error:''
        }
    },
    methods:{
        registerAuth(){
            axios.post('api/register', this.form).then(response => {
             if(response)  this.$router.push({path:'/login'})
            }).catch(error =>{
              // if(error.response.data.errors.name) {
              //     if (this.form.name.length>0){
              //         delete this.errors.errorName
              //     }
              //     this.error=error.response.data.errors.name
              //     delete this.errors.errorEmail
              //     delete this.errors.errorPassword
              //     this.errors.errorName = error.response.data.errors.name
              // } else if(error.response.data.errors.email){
              //     delete this.errors.errorName
              //     this.errors.errorEmail = error.response.data.errors.email
              // } else{
              //     delete this.errors.errorName
              //     delete this.errors.errorEmail
              //     this.errors.errorPassword = error.response.data.errors.password
              // // } else {
                  this.error=error.response.data.message
              //     console.log(this.error)
              // }
            })
        }
    }

}
</script>

<style scoped>
.cont{
    width: 100%;
    height: 100vh;
    background-image: url("https://media.istockphoto.com/id/643282534/video/using-laptop-late-in-night.jpg?s=640x640&k=20&c=ktoMKgkCZ31ABkMz3c9ARETQjrGyyCtxSFQ8NPD1ZAc=");
    background-size: 100% 100%;
}

.register h2{
    text-align: center;
}
.register{
    width: 500px;
    position: absolute;
    left: 50%;
    top:50%;
    transform: translate(-50%, -50%);
    color:white;
    padding: 20px 40px;
}
.register form button{
    margin:20px;
    background: rgba(255, 255, 255, 0.56);
    padding: 7px 20px;
    border-radius:50px;
    color: white;
}
.register form input{
    display:block;
    margin: 20px;
    width: 90%;
    padding: 7px 20px;
    border-radius:50px
}
</style>
