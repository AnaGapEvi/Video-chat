<template>
    <div>
        <video-chat
            :user="user"
            :others="others"
            pusher-key="config('broadcasting.connections.pusher.key')"
            pusher-cluster="config('broadcasting.connections.pusher.cluster')"
        >
        </video-chat>
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
            user:{},
            others:[]
        }
    },
    mounted(){
        this.getUsers()
    },
    methods:{
        getUsers(){
            axios.get('api/video_chat').then( response =>{
                this.user = response.data.user
                this.others = response.data.others
            })
        },
    }

}
</script>

<style lang="scss" scoped>

</style>
