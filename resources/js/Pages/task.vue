<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { formatNumber } from '@/util/format';
import { useTaskModalStore } from '@/Stores/Modals/TaskModalStore';
import { useTaskStore } from '@/Stores/TaskStore';
import { onMounted } from 'vue';
import { useUserStore } from '@/Stores/UserStore';

const useTaskModal = useTaskModalStore()
const taskStore = useTaskStore()

const props = defineProps({
    tasks: Array,
    tasks_daily: Array,
    user: Object,

});

onMounted(() => {
    taskStore.setTasks(props.tasks_daily, props.tasks)
})
</script>
<template>
    <MainLayout>
        <header class="gradient-element items-end flex">
            <div class="relative top-[5.2rem] w-full px-1 z-0">
                <div class="rounded-full w-full bg-yellow p-16"> </div>
            </div>
        </header>
        <main class="flex flex-col main-element z-10 gap-[27px]">
            <span class="text-[27px] font-semibold text-white text-center">
                Зарабатывай больше <br> Brawl Coin
            </span>
            <div class="flex-col flex gap-5 overflow-auto h-full justify-between">
                <div class="flex flex-col gap-[13px]">
                    <span class="text-[13px] font-semibold text-white">
                        Ежедневные заданий

                    </span>
                    <div v-if="taskStore.tasks_daily.length > 0" class="flex flex-col gap-[10px]">
                        <div v-for="task in taskStore.tasks_daily" @click="useTaskModal.openModal(task)"
                            class="flex justify-between px-[18px] py-3 bg-gray rounded-[18px] items-center">
                            <div class="flex gap-[10px] items-center">
                                <img class="w-[41px] h-max" :src="`/storage/${task.image}`" alt="">
                                <div class="flex flex-col gap-1">
                                    <span class="text-xs font-normal text-white">
                                        {{ task.title }}
                                    </span>
                                    <div class="flex gap-[5px] items-center">
                                        <img class="h-[22px]" src="assets/img/image2.png" alt="">
                                        <span class="text-sm font-normal text-yellow">
                                            +{{ formatNumber(task.reward) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <svg width="9" height="10" viewBox="0 0 9 10" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.73926 5.20804L0.521866 9.91921L0.521867 0.496857L8.73926 5.20804Z"
                                    fill="#FFBD20" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div v-if="taskStore.tasks.length > 0" class="flex flex-col gap-[13px]">
                    <span class="text-[13px] font-semibold text-white">
                        Список заданий
                    </span>
                    <div class="flex flex-col gap-[10px]">
                        <div v-for="task in taskStore.tasks" @click="useTaskModal.openModal(task)"
                            class="flex justify-between px-[18px] py-3 bg-gray rounded-[18px] items-center">
                            <div class="flex gap-[10px] items-center">
                                <img class="w-[41px] h-max" :src="`/storage/${task.image}`" alt="">
                                <div class="flex flex-col gap-1">
                                    <span class="text-xs font-normal text-white">
                                        {{ task.title }}
                                    </span>
                                    <div class="flex gap-[5px] items-center">
                                        <img class="h-[22px]" src="assets/img/image2.png" alt="">
                                        <span class="text-sm font-normal text-yellow">
                                            +{{ formatNumber(task.reward) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <svg width="9" height="10" viewBox="0 0 9 10" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.73926 5.20804L0.521866 9.91921L0.521867 0.496857L8.73926 5.20804Z"
                                    fill="#FFBD20" />
                            </svg>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </MainLayout>
</template>