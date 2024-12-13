<script setup>
import { useTaskModalStore } from '@/Stores/Modals/TaskModalStore'
import { VueFinalModal } from 'vue-final-modal'
import { useUserStore } from '@/Stores/UserStore'
import { useTaskStore } from '@/Stores/TaskStore'
import { toast } from 'vue3-toastify'
const taskModal = useTaskModalStore()
const userStore = useUserStore()

const taskStore = useTaskStore()

async function checkCompliance(task_id) {
    const response = await userStore.checkСompliance(task_id)
    if (response.success) {
        taskStore.removeTaskFromLists(task_id)
        taskModal.closeModal()
    }
    else {
        toast.error("Вы не выполнили задание")
    }
}
</script>

<template>
    <VueFinalModal v-model="taskModal.options.modelValue" :teleport-to="taskModal.options.teleportTo"
        :display-directive="taskModal.options.displayDirective" :hide-overlay="taskModal.options.hideOverlay"
        :overlay-transition="taskModal.options.overlayTransition"
        :content-transition="taskModal.options.contentTransition" :click-to-close="taskModal.options.clickToClose"
        :esc-to-close="taskModal.options.escToClose" :background="taskModal.options.background"
        :lock-scroll="taskModal.options.lockScroll" :reserve-scroll-bar-gap="taskModal.options.reserveScrollBarGap"
        :swipe-to-close="taskModal.options.swipeToClose" class="flex justify-center w-full items-center"
        content-class="max-w-[450px] absolute bottom-5  w-full py-2 px-4 text-white rounded-2xl bg-dark flex-col gap-6 flex">

        <div class="flex flex-col gap-3 text-center items-center justify-center">
            <img :src="`/storage/${taskModal.options.task.image}`" alt="" srcset="" class="w-11 ">
            <h1 class="text-xl font-bold max-w-[270px]">{{ taskModal.options.task.title }}</h1>
            <div class="flex items-center gap-1 justify-center text-gold font-semibold text-sm">
                <img class="w-5" src="/assets/img/image2.png" alt="" srcset="">
                {{ taskModal.options.task.reward }}
            </div>
            <div class="flex flex-col gap-2.5 w-full justify-center items-center">
                <a :href="taskModal.options.task.channel_link" class="btn btn-gold ">Подписаться</a>
                <button @click="checkCompliance(taskModal.options.task.id)"
                    class="btn btn-dark flex items-center gap-2 justify-center">
                    <span v-if="userStore.loading" class="loader"></span>
                    Проверить</button>
            </div>
        </div>
    </VueFinalModal>
</template>