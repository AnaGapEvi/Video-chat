<template>
    <div>
        <div>
            {{selected.name}} Chat
        </div>
        <div>
            <select
                v-model="selected"
                @change="$emit('roomchanged', selected)"
            >
                <option v-for="(room, index) in rooms"
                        :key="room.id"
                        :value="room">
                    {{room.name}}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    name: "chatRoomSelection",
    props:['rooms', 'currentRoom'],
    data(){
        return{
            selected:''
        }
    },
    created() {
        this.selected = this.currentRoom;
    }
}
</script>

<style scoped>

</style>
