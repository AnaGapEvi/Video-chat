<template>
        <div class="container-fluid chat_container mt-5">
            <div class="row" v-if="authenticated">
                <Rooms />
                <Video :username="username"></Video>
                <Logs />
            </div>
            <div class="row" v-else>
                <div class="username">
                    <form class="form-inline" @submit.prevent="submitUsername(username)">
                        <div class="form-group mb-2">
                            <input type="text" class="form-control" v-model="username" >
                        </div>
                        <button type="submit" class="btn btn-primary mb-2 Botton">Submit</button>
                    </form>
                </div>
            </div>
        </div>
</template>

<script>
import Rooms from './VideoChat/Rooms.vue'
import Video from './VideoChat/Video.vue'
import Logs from './VideoChat/Logs.vue'
import AddRoom from './VideoChat/AddRoom.vue'

export default {
    name: 'VideoApp',
    components: {
        Rooms,
        Video,
        Logs,
    },
    data() {
        return {
            username: "",
            authenticated: false
        }
    },
    methods: {
        submitUsername(username) {
            if(!username) {
                return alert('please provide a username');
            }
            this.authenticated = true;
        }
    }
}
</script>

<style scoped>
.box {
    border: 1px solid gray;
}

.username {
    margin: 12px auto 7px auto;
    color: wheat;
}

.Botton {
    color: #fff;
    background-color: #4d555f;
    border-color: #303840;
    padding: 8px;
    font-weight: bolder;
}
</style>
