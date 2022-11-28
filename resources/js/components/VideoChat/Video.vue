<template>
    <div class="col-md-6 box">
        <div class="roomTitle">
            <span v-if="loading"> Loading... {{roomName}}</span>
            <span v-else-if="!loading && roomName"> Connected to {{roomName}}</span>
            <span v-else>Select a room to get started</span>
        </div>
        <div class="row remote_video_container">
            <div id="remoteTrack"></div>
        </div>
        <div class="spacing"></div>
        <div class="row">
            <div id="localTrack"></div>
        </div>
    </div>
</template>

<script>
import { EventBus } from '../../Event'
import Twilio, { connect, createLocalTracks, createLocalVideoTrack } from 'twilio-video'
import axios from 'axios'

export default {
    name: "Video",
    props: ['username'],
    data() {
        return {
            loading: false,
            data: {},
            localTrack: false,
            remoteTrack: '',
            activeRoom: '',
            previewTracks: '',
            identity: '',
            roomName: 'Live',
        }
    },
    created() {},
    methods: {
        async getAccessToken() {
            return await axios.get(`api/token?identity=${this.username}`);
        },

        dispatchLog(message) {
            EventBus.$emit('new_log', message);
        },

        attachTracks(tracks, container) {
            tracks.forEach(function(track) {
                container.appendChild(track.attach());
            });
        },

        attachParticipantTracks(participant, container) {
            let tracks = Array.from(participant.tracks.values());
            this.attachTracks(tracks, container);
        },

        detachTracks(tracks) {
            tracks.forEach( (track) => {
                track.detach().forEach((detachedElement) => {
                    detachedElement.remove();
                });
            });
        },

        detachParticipantTracks(participant) {
            let tracks = Array.from(participant.tracks.values());
            this.detachTracks(tracks);
        },

        leaveRoomIfJoined() {
            if (this.activeRoom) {
                this.activeRoom.disconnect();
            }
        },

        createChat(room_name) {
            this.loading = true;
            const VueThis = this;

            this.getAccessToken().then( (data) => {
                VueThis.roomName = null;
                const token = data.data.token;
                let connectOptions = {
                    name: room_name,
                    logLevel: 'debug',
                    audio: true,
                    video: { width: 400 }
                };
                this.leaveRoomIfJoined();

                document.getElementById('remoteTrack').innerHTML = "";

                Twilio.connect(token, connectOptions).then(function(room) {
                    VueThis.dispatchLog('Successfully joined a Room: '+ room_name);

                    VueThis.activeRoom = room;
                    VueThis.roomName = room_name;
                    VueThis.loading = false;
                });
            })
        },
    }
}
</script>

<style scoped>
.remote_video_container {
    left: 0;
    margin: 0;
    border: 1px solid rgb(124, 129, 124);
}
#localTrack video {
    border: 3px solid rgb(124, 129, 124);
    margin: 0px;
    max-width: 50% !important;
    background-repeat: no-repeat;
}
.spacing {
    padding: 20px;
    width: 100%;
}
.roomTitle {
    border: 1px solid rgb(124, 129, 124);
    padding: 4px;
    color: dodgerblue;
}
</style>
