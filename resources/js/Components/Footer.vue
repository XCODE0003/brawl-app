<script setup>
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { useUserStore } from '@/Stores/UserStore';

const activePage = usePage().props.activePage;
const userStore = useUserStore();


</script>

<template>

    <footer class="sticky container pb-10 px-[27px] mx-auto bottom-0 z-20 gap-6 flex flex-col">
        <div :class="activePage === 'friend' ? 'flex gap-2' : 'hidden'">
            <a :href="userStore.shareLink()"
                class="p-[19px] flex gap-[10px] justify-center text-sm font-semibold w-full bg-yellow items-center rounded-[15px]">
                Пригласить друга
                <img class="w-[14px]" src="assets/img/image10.png" alt="">
            </a>
            <button @click="userStore.copyRefLink"
                class="min-w-[58px] bg-yellow rounded-[15px] justify-center flex items-center">
                <img class="w-[22px]" src="assets/img/image11.png" alt="">
            </button>
        </div>
        <div class="rounded-2xl bg-gray w-full justify-between px-[30px] py-[10px] flex max-h-[74px]">
            <Link :class="activePage === 'boost' ? 'active-page' : ''" href="/boost"
                class="flex flex-col gap-1 items-center text-xs font-light text-white">
            <img class="w-[34px]" src="assets/img/image4.png" alt="">
            Бусты
            </Link>
            <Link :class="activePage === 'friend' ? 'active-page' : ''" href="/friend"
                class="flex flex-col gap-1 items-center text-xs font-light text-white">
            <img class="w-[34px]" src="assets/img/image5.png" alt="">
            Друзья
            </Link>
            <Link :class="activePage === 'index' ? 'active-page' : ''" href="/"
                class="flex flex-col gap-1 items-center text-xs font-light text-white">
            <img class="w-[34px]" src="assets/img/image2.png" alt="">
            Добывать
            </Link>
            <Link :class="activePage === 'task' ? 'active-page' : ''" href="/task"
                class="flex flex-col gap-1 items-center text-xs font-light text-white">
            <img class="w-[34px]" src="assets/img/image6.png" alt="">
            Задания
            </Link>
            <Link :class="activePage === 'shop' ? 'active-page' : ''" href="/shop"
                class="flex flex-col gap-1 items-center text-xs font-light text-white">
            <img class="w-[34px]" src="assets/img/image7.png" alt="">
            Магазин
            </Link>
        </div>
    </footer>
</template>