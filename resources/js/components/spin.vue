<template>
    <div class="spin">
        <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
<!--                <span class="sr-only"></span>-->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "spin",
    data() {
        return {

        }
    },
    methods: {

    }
}
</script>

<style scoped>
.spin{
    position: absolute;
    left: 50%;
    top:50%;
    transform: translate(-50%, -50%);
}
</style>
