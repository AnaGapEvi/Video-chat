<template>
    <div>
        <h2>
            <chat-room-selection
                v-if="currentRoom.id"
                :rooms="chatRooms"
                :currentRoom="currentRoom"
                v-on:roomchanged="setRoom( $event)"
            />
        </h2>
        <h1>Container</h1>
        <message-container :messages="messages"/>
        <input-message
            :room="currentRoom"
            v-on:messagesent="getMessages()"
        />


    </div>
</template>

<script>
import MessageContainer from "./messageContainer.vue";
import InputMessage from "./inputMessage.vue";
import ChatRoomSelection from "./chatRoomSelection.vue";
import VideoChat from "../auth/VideoChat.vue";

export default {
    name: "Container",
    components: {VideoChat, ChatRoomSelection, InputMessage, MessageContainer},
    data(){
        return{
            chatRooms:[],
            currentRoom:[],
            messages:[],
            user:{},
            others:[]

        }
    },
    watch:{
        currentRoom() {
            this.connect();
        }
    },
    created(){
      this.getRooms()
    },
    mounted() {

    },
    methods:{
        connect(){
            if(this.currentRoom.id){
                let vm = this;
                this.getMessages()
                // Echo.connector.pusher.config.auth.headers.Authorization = `Bearer ${localStorage.getItem('access_token')}`;
                window.Echo.private("chat." + this.currentRoom.id)
                    .listen('.message.new', e =>{
                        vm.getMessages()
                    })
            }
        },
        getRooms(){
            this.axios.get('api/chat/rooms')
                .then( response => {
                    this.chatRooms=response.data
                    console.log(this.chatRooms)
                    this.setRoom(response.data[0])
                })
                .catch(error =>{
                    console.log(error)
                })
        },
        setRoom(room){
            this.currentRoom=room
        },
        getMessages(){
            this.axios.get('api/chat/room/'+this.currentRoom.id + '/messages')
                .then( response => {
                    this.messages = response.data
                })
                .catch( error => {
                    console.log(error )
                })
        }
    }
}
</script>

<style scoped>

</style>
