<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { computed } from 'vue';
import { useUserStore } from '@/Stores/UserStore';
import { ref } from 'vue';
import { formatNumber } from '@/util/format';
const props = defineProps({
    boosts: Array,
    boost_users: Array,
    user: Object
});
const boosts_users = ref(props.boost_users)
const userStore = useUserStore()
userStore.setUser(props.user)
async function buyBoost(boost_id) {
    if (getBoostPriceInfoById(boost_id).value.price > parseInt(userStore.user.coins)) {
        alert('Недостаточно монет')
        return
    }
    const response = await userStore.buyBoost(boost_id)

    if (response.success) {
        userStore.user.coins = response.coins
        boosts_users.value = response.boost_user
    }
    else {
        alert(response.message)
    }
}
const boostLevels = computed(() => {
    const levels = {};
    props.boosts.forEach(boost => {
        levels[boost.id] = boosts_users.value.find(item => item.boost_id === boost.id)?.lvl ?? 0;
    });
    return levels;
});
const getBoostLevel = (boostId) => {
    return boostLevels.value[boostId];
};
const getBoostPriceInfoById = (boostId) => {

    return computed(() => {
        const level = getBoostLevel(boostId);
        return props.boosts.find(item => item.id === boostId).lvl_prices[level];
    });
};
const getBoostPriceInfo = (boost) => {
    return computed(() => {
        const level = getBoostLevel(boost.id);
        return boost.lvl_prices[level];
    });
};
</script>
<template>
    <MainLayout>
        <header class="gradient-element items-end flex">
            <div class="relative top-[5.2rem] w-full px-1 z-0">
                <div class="rounded-full w-full bg-yellow p-16"> </div>
            </div>
        </header>
        <main class="flex  flex-col main-element z-10 gap-[27px]">
            <div class="flex gap-2 text-4xl font-bold text-white justify-center">
                <img class="w-10" src="assets/img/image2.png" alt="">
                {{ Number(userStore.user.coins).toLocaleString('ru-RU', { useGrouping: true }) }}
            </div>
            <div class="flex-col flex gap-5 overflow-auto h-full justify-between">
                <div class="flex flex-col gap-[10px]">
                    <div v-for="boost in boosts" class="px-[17px] py-[8px] rounded-[18px] bg-gray flex justify-between">
                        <div class="flex gap-[26px] items-center">
                            <img class="w-[35px]" :src="'/storage/' + boost.image" alt="">
                            <div class="flex flex-col gap-[11px]">
                                <span class="text-[13px] font-medium text-white">
                                    {{ boost.name }}
                                </span>
                                <span class="text-[11px] font-normal text-yellow">
                                    Ур. {{ getBoostLevel(boost.id) }}
                                </span>
                            </div>
                        </div>
                        <div v-if="boost.max_lvl > getBoostLevel(boost.id)" class="flex flex-col gap-[11px]">
                            <button
                                :disabled="userStore.loading || getBoostPriceInfo(boost).value.price > parseInt(userStore?.user?.coins)"
                                @click="buyBoost(boost.id)"
                                class="flex gap-[2px] px-[10px] py-[6px] rounded-[7px] bg-yellow items-center">
                                <div v-if="userStore.loading" class="loader-small"></div>
                                <img class="w-[11px]" src="assets/img/image2.png" alt="">
                                <span class="text-[10px] font-semibold">
                                    {{ formatNumber(getBoostPriceInfo(boost).value.price) }}
                                </span>
                            </button>
                            <span class="text-[10px] font-medium text-white">
                                +{{ formatNumber(getBoostPriceInfo(boost).value.income_per_hour) }} в час

                            </span>
                        </div>
                        <div v-else>
                            <span class="text-[10px] font-medium text-white">
                                У вас максимальный уровень
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </MainLayout>
</template>
