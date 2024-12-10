<script setup>
import { ref } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { useUserStore } from '@/Stores/UserStore';
import { onBeforeUnmount } from 'vue';
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    total_income: {
        type: Number,
        required: true
    }
})
const timeout = ref(null);
const userStore = useUserStore();
userStore.setUser(props.user);
let addEnergyInterval = null;
addEnergyInterval = setInterval(() => {
    if (userStore.user.energy < userStore.user.energy_max) {
        userStore.addEnergy(1);
    }
}, 1000);
let counter_tap = 0;
const isPressed = ref(false);
let tapExecuted = false;

function handleTouchStart() {
    isPressed.value = true;
    tapExecuted = false;
}

function handleTouchEnd() {
    isPressed.value = false;
    if (!tapExecuted) {
        tap();
        tapExecuted = true;
    }
}

function handleClick(event) {
    if (tapExecuted) {
        event.preventDefault();
    } else {
        tap();
    }
}

async function tap() {
    if (userStore.user.energy <= 0) return;
    clearTimeout(timeout.value);
    userStore.addCoins(1);
    userStore.removeEnergy(1);
    counter_tap++;
    timeout.value = setTimeout(() => {
        userStore.creditingTap(counter_tap);
        counter_tap = 0;
    }, 1000);
}
onBeforeUnmount(() => {
    clearInterval(addEnergyInterval)
})
</script>

<template>
    <MainLayout>
        <header class="gradient-element items-end flex">
            <div class="px-8 py-[105px] gap-2 items-center w-full hidden">
                <img class="w-8" src="assets/img/user.png" alt="">
                <span class="text-sm text-white font-normal">
                    surgeon.design
                </span>
            </div>
            <div class="relative top-[5.2rem] w-full px-1 z-0">
                <div class="rounded-full w-full bg-yellow p-16"> </div>
            </div>
        </header>
        <main class="flex flex-col main-element z-10 gap-10">
            <div class="rounded-2xl bg-gray flex justify-between py-3 px-6 items-center">
                <div class="flex flex-col gap-1">
                    <span class="text-xs font-normal text-white">
                        Прибыль в час
                    </span>
                    <div class="flex gap-1 items-center text-white text-sm font-normal">
                        <img class="w-5" src="assets/img/image2.png" alt="">
                        {{ total_income }}
                    </div>
                </div>
                <Link href="/boost"
                    class="px-3 py-2 pb-[0.4rem] rounded-xl text-black text-sm font-semibold bg-yellow h-max">
                Увеличить
                </Link>
            </div>
            <div class="flex-col flex gap-5 overflow-auto h-full justify-between">
                <div class="flex flex-col gap-[20px]">
                    <div class="flex flex-col gap-5">
                        <div class="flex gap-2 text-4xl font-bold text-white justify-center">
                            <img class="w-10" src="assets/img/image2.png" alt="">
                            {{ Number(user.coins).toLocaleString('ru-RU', { useGrouping: true }) }}
                        </div>
                        <div class="justify-center flex items-center">
                            <img style="touch-action: pan-y;" @click="handleClick" @touchstart="handleTouchStart"
                                @touchend="handleTouchEnd" :class="{ 'translate-y-1': isPressed }"
                                class="max-w-84 active:translate-y-1 flex-1 relative z-10" src="assets/img/image2.png"
                                alt="">
                            <span class="ellipse-blur w-48 h-48 bg-yellow  absolute z-0"></span>
                        </div>
                    </div>
                    <div class="flex justify-between gap-3 items-center">
                        <span class="flex items-center gap-1 text-sm font-normal text-white">
                            <img class="w-3" src="assets/img/image3.png" alt="">
                            {{ user.energy }}/{{ user.energy_max }}
                        </span>
                        <span class="text-sm font-normal text-white">
                            Энергия
                        </span>
                    </div>
                </div>

            </div>

        </main>
    </MainLayout>
</template>
