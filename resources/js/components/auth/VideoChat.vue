<template>
    <div class="container">
        <h1 class="text-center">Laravel Video Chat</h1>
        <div class="video-container" ref="video-container">
            <spin v-if="spin"></spin>
            <video class="video-here" ref="video-here" autoplay></video>
            <video class="video-there" ref="video-there" autoplay></video>
            <b-button variant="info" @click.prevent="setupVideoChat()" >
                <b-icon icon="camera-video"></b-icon>
            </b-button>
            <b-button variant="danger" @click.prevent="stopVideo()" >
                <b-icon icon="camera-video-off"></b-icon>
            </b-button>
            <b-button variant="danger" @click.prevent="stopConnect(1)" >
                <b-icon icon="telephone-x-fill"></b-icon>
            </b-button>
            <div class="text-right" v-for="(name,userId) in others" :key="userId">
                <b-button variant="info" @click="startVideoChat(userId)" v-text="`Talk with ${name}`"/>
                <b-button variant="info" @click="getMedia()" >Audio </b-button>
            </div>
        </div>
    </div>
</template>
<script>
import Pusher from 'pusher-js';
import Peer from 'simple-peer';
import axios from "axios";
import Spin from "../spin.vue";
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
    computed:{

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
                        // this.stream=stream
                        videoThere.srcObject = stream;
                        videoThere.play()
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
            this.stream = null
            try {
                this.stream = await navigator.mediaDevices.getUserMedia({'audio': true});
                if(stream.MediaStream.active===true){
                    console.log(stream.MediaStream)
                }
                console.log(stream)

            } catch (err) {
                /* handle the error */
            }
            const constraints = {
                'audio': true,
                'video': true
            }
            const stream = await navigator.mediaDevices.getDisplayMedia(constraints);
            const videoHere = this.$refs['video-here'];
            this.$refs['video-here'].style.display = 'block'
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

        stopVideo(){
            this.getStopPeer()
        },
        stopConnect(userId){
            // let stream = this.stream
            console.log(userId)
            let peer = new Peer()
            peer.on('disconnect', userId =>{
                if(this.peers[userId]) this.peers[userId].close()
                this.stream=null
                console.log(this.stream)

            })


        },
        async getStopPeer(){
            const constraints = {
                'audio': true,
                'video': false

            }
            console.log(constraints)
            const stream = await navigator.mediaDevices.getUserMedia(constraints);

           // stream = null;
            const videoHere = this.$refs['video-here'];
            this.$refs['video-here'].style.display = 'none'
            videoHere.srcObject = stream;
            this.stream = stream;

        },
        async closeVoice(){

        },
        getLocalStream() {
            navigator.mediaDevices
                .getUserMedia({ video: false, audio: true })
                .then((stream) => {
                    window.localStream = stream; // A
                    window.localAudio.srcObject = stream; // B
                    window.localAudio.autoplay = true; // C
                })
                .catch((err) => {
                    console.error(`you got an error: ${err}`);
                });
        },
        async getAudio(){

            if (!navigator.mediaDevices?.enumerateDevices) {
                return 'navigate error'
            } else {
                // List cameras and microphones.
                navigator.mediaDevices.enumerateDevices()
                    .then((devices) => {
                        devices.forEach((device) => {
                            console.log(`${device.kind}: ${device.label} id = ${device.deviceId}`);
                        });
                    })
                    .catch((err) => {
                        console.error(`${err.name}: ${err.message}`);
                    });
            }
            // navigator.mediaDevices
            //     .getUserMedia({ video: false, audio: true })
            //     .then((stream) => {
            //
            //         window.localStream = stream;
            //         window.localAudio.srcObject = stream;
            //         window.localAudio.autoplay = true;
            //     })
            //     .catch((err) => {
            //         console.error(`you got an error: ${err}`);
            //     });
            // Copy to Clipboard

            // await navigator.mediaDevices.getUserMedia({audio: true, video: true});
                // let devices = await navigator.mediaDevices.getDisplayMedia();
                // console.log(devices);


            // try {
            // navigator.mediaDevices.enumerateDevices()
            // let devices = await navigator.mediaDevices.enumerateDevices();
            // let audio = await navigator.mediaDevices.selectAudioOutput();
            // console.log(devices, 'divaceeeee', audio);
            // .then((devices) => {
            //     devices.forEach((device) => {
            //         if(device.label===""){
            //             return
            //         } else{
            //
            //         };
            //     });
            // })
            // }catch (){
            //
            // }
            // let devices = await navigator.mediaDevices.enumerateDevices();
            // console.log(devices, 'divaceeeee');

            // await navigator.mediaDevices.getUserMedia({
            //     audio: true });
        },
        async getMedia() {
            let stream = null;

            try {
                stream = await navigator.mediaDevices.getUserMedia({'audio': true});
                if(stream.MediaStream.active===true){
                    console.log('sbj')
                }
                console.log(stream)
                /* use the stream */
            } catch (err) {
                /* handle the error */
            }

            // document.querySelector('#myButton').addEventListener('click', () => {



            // Display prompt and log selected device or error
            // navigator.mediaDevices
            //     .selectAudioOutput()
            //     .then((device) => {
            //         console.log(`${device.kind}: ${device.label} id = ${device.deviceId}`);
            //     })
            //     .catch((err) => {
            //         console.error(`${err.name}: ${err.message}`);
            //     });
            // });
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
    position: absolute;
    left: 10px;
    bottom: 16px;
    border: 1px solid #000;
    border-radius: 2px;
    z-index: 2;
    display: none;
}
.video-there {
    width: 100%;
    height: 100%;
    background: #d5e4e7;
    z-index: 1;
}
.user-bos button{
    margin:15px;
}
</style>
