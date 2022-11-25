<template>
    <div class="input-section">
        <input
            type="text"
            v-model="data.message"
            @keyup.enter="sendMessage()"
            placeholder="Say something..."/>
        <button @click="sendMessage()">Send</button>
    </div>
</template>

<script>
export default {
    name: "inputMessage",
    props:['room'],
    data(){
        return{
            data: {
                message: ''
            }
        }
    },
    methods:{
        sendMessage(){
            if(this.message=''){
                return
            }
            this.axios.post(`api/chat/room/${this.room.id}/message`,  this.data)
                .then(response => {
                    if(response){
                        this.data.message='';
                        this.$emit('messagesent');
                    }
                }).catch( error =>{
                console.log(error, this.message)
            })
        }
    }
}
</script>

<style scoped>

</style>
