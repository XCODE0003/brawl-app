import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useTaskModalStore = defineStore('taskModal', () => {
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
        task: null,
    })


    const openModal = (task) => {
        options.value.modelValue = true
        options.value.task = task
    }

    const closeModal = () => {
        options.value.modelValue = false
    }

    return { options, openModal, closeModal }
}) 
