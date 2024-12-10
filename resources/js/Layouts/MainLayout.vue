<script setup>
import Footer from '@/Components/Footer.vue';
import { ModalsContainer } from 'vue-final-modal'
import FriendModal from '@/Components/Modals/FriendModal.vue'
import TaskModal from '@/Components/Modals/TaskModal.vue'
import Loading from '@/Components/Loading.vue'
import { router } from '@inertiajs/vue3'
import { onMounted } from 'vue'

onMounted(() => {
    router.on('start', () => {
        document.body.classList.add('loading')
    })

    router.on('finish', () => {
        document.body.classList.remove('loading')
    })

})
</script>

<template>

    <transition appear name="fade" mode="out-in">
        <div :class="{ 'opacity-25': $page.props.loading }" :key="$page.url" class="container min-h-[80vh] mx-auto">
            <slot />
        </div>
    </transition>
    <Footer />
    <FriendModal />
    <TaskModal />
    <Loading v-show="$page.props.loading" />
    <ModalsContainer />
</template>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
