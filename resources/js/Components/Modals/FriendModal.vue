<script setup>
import { useFriendModalStore } from '@/Stores/Modals/FriendStore'
import { useUserStore } from '@/Stores/UserStore'
import { VueFinalModal } from 'vue-final-modal'
import { declension } from '@/util/format'
const useFriendModal = useFriendModalStore()
const userStore = useUserStore()

</script>

<template>
    <VueFinalModal v-model="useFriendModal.options.modelValue" :teleport-to="useFriendModal.options.teleportTo"
        :display-directive="useFriendModal.options.displayDirective" :hide-overlay="useFriendModal.options.hideOverlay"
        :overlay-transition="useFriendModal.options.overlayTransition"
        :content-transition="useFriendModal.options.contentTransition"
        :click-to-close="useFriendModal.options.clickToClose" :esc-to-close="useFriendModal.options.escToClose"
        :background="useFriendModal.options.background" :lock-scroll="useFriendModal.options.lockScroll"
        :reserve-scroll-bar-gap="useFriendModal.options.reserveScrollBarGap"
        :swipe-to-close="useFriendModal.options.swipeToClose" class="flex justify-center w-full items-center"
        content-class="max-w-[450px] absolute bottom-5  w-full py-2 px-4 text-white rounded-2xl bg-dark flex-col gap-6 flex">

        <div class="flex flex-col gap-3 text-center items-center justify-center">
            <img src="/assets/img/error.png" alt="" srcset="" class="w-11 ">
            <h1 class="text-xl font-bold max-w-[270px]">Чтобы получить подарок необходимо пригласить больше друзей</h1>
            <p class="text-xl">Вам осталось позвать {{ declension(useFriendModal.calculateRemainingFriends(), ['друг',
                'друга', 'друзей']) }} </p>
            <div class="flex flex-col gap-2.5 w-full justify-center items-center">
                <a :href="userStore.shareLink()" class="btn btn-gold ">Поделится</a>
                <button @click="useFriendModal.closeModal" class="btn btn-dark">Закрыть</button>
            </div>
        </div>
    </VueFinalModal>
</template>