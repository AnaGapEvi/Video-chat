<template>
    <div>{{message.user_id}}: {{message.message}}</div>
</template>

<script>
export default {
    name: "MessageItem",
    props:['message'],
    data(){
        return{

        }
    }
}
</script>

<style scoped>

</style>
