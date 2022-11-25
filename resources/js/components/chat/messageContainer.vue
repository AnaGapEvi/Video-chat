<template>
    <div>
        <div v-for="(message, index) in messages" :key="index">
            <message-item :message="message"/>
        </div>
    </div>
</template>

<script>
import MessageItem from "./MessageItem.vue";

export default {
    name: "messageContainer",
    components: {MessageItem},
    props:['messages'],
    data(){
        return{

        }
    },
    mounted() {

    },
    methods:{

    }
}
</script>

<style scoped>

</style>
