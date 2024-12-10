<script setup>
import { ref } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { useUserStore } from '@/Stores/UserStore';
import { formatNumber } from '@/util/format';
const userStore = useUserStore();
const props = defineProps({
    user: Object,
    friends: Array,
    setting: Object,
    friend: Object
})

userStore.setUser(props.user);

</script>

<template>
    <MainLayout>
        <header class="gradient-element items-end flex">
            <div class="relative top-[5.2rem] w-full px-1 z-0">
                <div class="rounded-full w-full bg-yellow p-16"> </div>
            </div>
        </header>
        <main class="flex flex-col main-element z-10 gap-[30px]">
            <div class="flex flex-col gap-[10px] text-center text-white">
                <span class="text-3xl font-semibold">
                    Пригласите друзей!
                </span>
                <span class="text-sm font-normal ">
                    Вы и ваш друг получите бонусы!
                </span>
            </div>
            <div class="flex flex-col gap-[10px]">
                <div class="task-friends-elements">
                    <img class="w-[49px]" src="assets/img/image8.png" alt="">
                    <div class="flex flex-col gap-[5px]">
                        <span class="text-sm font-medium text-white">
                            Пригласить друга
                        </span>
                        <div class="flex gap-[5px] items-center">
                            <img class="w-[22px]" src="assets/img/image2.png" alt="">
                            <span class="text-sm font-normal text-yellow">
                                +{{ formatNumber(setting.bonus_start) }}
                            </span>
                            <span class="text-xs font-normal text-white">
                                Для вас и вашего друга
                            </span>
                        </div>
                    </div>
                </div>
                <div v-if="userStore.user.referral_code"
                    class="task-friends-elements massage text-xs font-light text-white">
                    Вы уже являетесь рефералом, приглашенным <span class="text-yellow">{{ friend.username }}</span>
                </div>
            </div>
            <div class="flex-col flex gap-5 overflow-auto h-full justify-between">
                <div class="flex flex-col gap-[15px]">
                    <div class="flex justify-between text-white text-sm font-normal items-center">
                        Список ваших друзей
                        <img class="h-[14px]" src="assets/img/image9.png" alt="">
                    </div>
                    <div class="flex flex-col gap-[10px] overflow-auto">
                        <div v-if="props.friends.length > 0" class="friends-elements">
                            <span v-for="friend in props.friends" class="text-sm font-medium text-white">
                                {{ friend.username }}
                            </span>
                        </div>
                        <div v-else class="friends-elements message">
                            <span class="text-sm  text-white opacity-25">
                                Вы ещё никого не пригласили!
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </MainLayout>
</template>