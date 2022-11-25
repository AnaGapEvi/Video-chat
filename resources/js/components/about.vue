<template>
    <div >
        <spin v-if="loader"></spin>
        <div v-else>
            <div class="d-flex">
                <video-chat :user="user"
                            :others="others"
                            pusher-key="config('broadcasting.connections.pusher.key')"
                            pusher-cluster="config('broadcasting.connections.pusher.options.cluster')">
                </video-chat>

            </div>
            <div>

            </div>
        </div>
<!--        <h1> About</h1>-->



    </div>
</template>

<script>
import Spin from "./spin.vue";
import axios from "axios"
import VideoChat from "./auth/VideoChat.vue";
export default {
    components: {VideoChat, Spin},
    data(){
        return{
            loader:false,
            user:{id:1, name:"Ani"},
            others:[
                {id:2, name:"Hayk"},
                {id:3, name:"Jhoe"}
            ]
        }
    },
    mounted(){
        this.getPosts()
    },
    methods:{
        getPosts(){
            axios.get('/api/posts').then( response =>{
                return  response.data
            })
        }
    }

}
</script>

<style lang="scss" scoped>

</style>
