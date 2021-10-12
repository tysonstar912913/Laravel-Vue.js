<template>
    <div>
        <img
            :src="
                value
                ? '/storage/' + value
                : '/adminlte/img/default-user-avatar.png'
            "
            alt="avatar"
            class="avatar"
            @error="handleAvatarError"
        />
    </div>
</template>


<script>
export default {
    props: ['value', 'field'],
    data() {
        return {
            // Code...
        }
    },
    created() {
        // Code...
    },
    methods: {
        handleAvatarError(e) {
            e.target.src = '/adminlte/img/default-user-avatar.png'
        },
    }
}
</script>


<style scoped>
img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
}
</style>

