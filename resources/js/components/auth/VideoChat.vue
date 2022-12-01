<template>
    <div class="container">
        <h1 class="text-center">Laravel Video Chat</h1>
        <div class="video-container" ref="video-container">
            <spin v-if="spin"></spin>
            <video class="video-here" ref="video-here" autoplay>
            </video>
            <video class="video-there" ref="video-there" autoplay>

            </video>
            <b-button variant="info" @click.prevent="setupVideoChat()" ><b-icon icon="camera-video"></b-icon></b-button>
            <div class="text-right" v-for="(name,userId) in others" :key="userId">
                <b-button variant="info" @click="startVideoChat(userId)" v-text="`Talk with ${name}`"/>
            </div>
        </div>
    </div>
</template>
<script>
import Pusher from 'pusher-js';
import Peer from 'simple-peer';
import axios from "axios";
import Spin from "../spin.vue";
// var parcelRequire;
export default {
    components: {Spin},
    props: ['user', 'others'],
    data() {
        return {
            pusherKey:'4cb64a8405957ea87e24',
            pusherCluster:'ap2',
            channel: null,
            stream: null,
            peers: {},
            spin:true
        }
    },
    mounted() {
    },
    methods: {
        startVideoChat(userId) {
            this.getPeer(userId, true);
        },
        getPeer(userId, initiator) {
            if(this.peers[userId] === undefined) {
                let peer = new Peer({
                    initiator,
                    stream: this.stream,
                    trickle: false
                });
                peer.on('signal', (data) => {
                    this.channel.trigger(`client-signal-${userId}`, {
                        userId: this.user.id,
                        data: data
                    });
                })
                    .on('stream', (stream) => {
                        this.spin=false
                        const videoThere = this.$refs['video-there'];
                        this.stream=stream
                        videoThere.srcObject = stream;
                    })
                    .on('close', () => {
                        const peer = this.peers[userId];
                        if(peer !== undefined) {
                            peer.destroy();
                        }
                        delete this.peers[userId];
                    });
                this.peers[userId] = peer;
            }
            return this.peers[userId];
        },
        async setupVideoChat() {
            const constraints = {
                'audio': true,
                'video': true

            }
            const stream = await navigator.mediaDevices.getDisplayMedia(constraints);
            const videoHere = this.$refs['video-here'];
            videoHere.srcObject = stream;
            this.stream = stream;

            const pusher = this.getPusherInstance();
            this.channel = pusher.subscribe('presence-video-chat');
            this.channel.bind(`client-signal-${this.user.id}`, (signal) =>
            {
                const peer = this.getPeer(signal.userId, false);
                peer.signal(signal.data);
            });
        },
        getPusherInstance() {
            return new Pusher(this.pusherKey, {
                authEndpoint: 'api/auth/video_chat',
                cluster: this.pusherCluster,
                auth: {
                    headers: {
                        'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content,
                        Authorization: `Bearer ${localStorage.getItem('access_token')}`
                    }
                }
            });
        },
    }
};
</script>
<style>
.video-container {
    width: 500px;
    height: 380px;
    margin: 8px auto;
    border: 3px solid #000;
    position: relative;
    box-shadow: 1px 1px 1px #9e9e9e;
}
.video-here {
    width: 130px;
    /*height: 130px;*/
    position: absolute;
    left: 10px;
    bottom: 16px;
    border: 1px solid #000;
    border-radius: 2px;
    z-index: 2;
}
.video-there {
    width: 100%;
    height: 100%;
    background: #d5e4e7;
    z-index: 1;
}
.user-box{
    /*text-align: right;*/
    display: flex;
    flex-wrap: wrap;
    text-align:center;
}
.user-bos button{
    margin:15px;
}
</style>
