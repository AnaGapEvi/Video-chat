<template>
    <div>
        <h1>Home</h1>
        {{user.email}}
    </div>
</template>

<script>
import axios from "axios";

export default {
    data(){
        return{
            user:{},
            error:''
        }
    },
    mounted() {
        this.authUser()
    },
    methods: {
        authUser() {
            axios.get('/api/auth-user').then(response => {
                this.user = response.data.user
            }).catch(error => {
                this.error = error.response.data.error
            })
        },

    }
}
</script>

<style lang="scss" scoped>

</style>
