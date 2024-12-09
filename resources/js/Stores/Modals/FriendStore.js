import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useFriendModalStore = defineStore('friendModal', () => {
    const options = ref({
        teleportTo: 'body',
        modelValue: false,
        displayDirective: 'if',
        hideOverlay: false,
        overlayTransition: 'vfm-fade',
        contentTransition: 'vfm-slide-down',
        clickToClose: true,
        escToClose: true,
        background: 'non-interactive',
        lockScroll: true,
        reserveScrollBarGap: true,
        swipeToClose: 'down',
        friends: 0,
        item: null,
    })



    function calculateRemainingFriends() {
        const requiredFriends = options.value.item.step_friend_invite;
        const currentFriends = options.value.friends;
        return Math.max(0, requiredFriends - currentFriends);
    }

    const openModal = (item) => {
        options.value.item = item
        options.value.modelValue = true
    }

    const closeModal = () => {
        options.value.modelValue = false
    }

    return { options, openModal, closeModal, calculateRemainingFriends }
}) 
