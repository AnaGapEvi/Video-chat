<template>
    <div class="col-md-3 rooms">
        <div class="room" v-for="room in rooms" v-bind:key="room.id" @click="showRoom(room.name)">
            {{room.name}}
        </div>
        <AddRoom />
    </div>
</template>

<script>
import { EventBus } from '../../Event'
import AddRoom from '../VideoChat/AddRoom.vue'

export default {
    name: "Rooms",
    components: {
        AddRoom
    },
    data() {
        return {
            rooms: [],
            roomCount: Number,
        }
    },

    created() {
        EventBus.$on('new_room', (data) => {
            this.roomCount++;
            this.rooms.push({id: this.roomCount, name: data});
        });
        this.getRooms()
    },
    methods: {
        showRoom(room) {
            EventBus.$emit('show_room', room);
        },
        getRooms() {
            this.axios.get('api/chat/rooms')
                .then(response => {
                    console.log(response.data)
                    this.rooms = response.data
                    this.roomCount=this.rooms.length
                    console.log(this.roomCount)
                })
        }
    }

}
</script>

<style scoped>
.rooms > .room {
    border: 1px solid rgb(124, 129, 124);
    padding: 13px;
    margin: 3px 0px;
    color: black;
}

.rooms {
    border: 1px solid rgb(64, 68, 64);
    cursor: pointer;
}
</style>
