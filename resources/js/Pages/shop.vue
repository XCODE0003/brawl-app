<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { defineProps } from 'vue';
import { formatNumber } from '@/util/format';
import { useFriendModalStore } from '@/Stores/Modals/FriendStore';
const props = defineProps({
    items: {
        type: Array,
        required: true
    },
    friends: {
        type: Number,
        required: true
    }
});

const FriendStore = useFriendModalStore();
FriendStore.friends = props.friends;

</script>
<template>
    <MainLayout>
        <header class="gradient-element items-end flex">
            <div class="relative top-[5.2rem] w-full px-1 z-0">
                <div class="rounded-full w-full bg-yellow p-16"> </div>
            </div>
        </header>
        <main class="flex flex-col main-element z-10 gap-[27px]">

            <div class="flex gap-2 leading-none text-4xl font-bold text-white justify-center flex-col">
                <span class="text-[27px] font-semibold text-white text-center">
                    Обменяй Brawl Coin
                </span>
                <span class="text-[12px] font-normal text-white text-center">
                    На подарки в игру
                </span>
            </div>
            <div class="flex-col flex gap-5 overflow-auto h-full justify-between">
                <div v-for="item in items" class="flex flex-col gap-[10px]">
                    <div class="px-[17px] py-[8px] rounded-[18px] bg-gray flex justify-between">
                        <div class="flex gap-[26px] items-center">
                            <img class="w-[35px] h-[35px]" :src="`/storage/${item.image}`" alt="">
                            <div class="flex flex-col items-start justify-start gap-[11px]">
                                <span class=" font-semibold text-white">
                                    {{ item.title }}
                                </span>

                            </div>
                        </div>
                        <div class="flex flex-col gap-[11px] items-center justify-center">
                            <button @click="FriendStore.openModal(item)"
                                class="flex gap-[2px] px-[10px] py-[6px] rounded-[7px] bg-yellow items-center">
                                <img class="w-[11px]" src="assets/img/image2.png" alt="">
                                <span class="text-[12px] font-bold">
                                    {{ formatNumber(item.price) }}
                                </span>
                            </button>

                        </div>
                    </div>
                </div>

            </div>
        </main>
    </MainLayout>

</template>