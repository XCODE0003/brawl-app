import { defineStore } from 'pinia'
import axios from 'axios'

export const useUserStore = defineStore('user', {
    state: () => ({
        user: null,
        isAuthenticated: false,
        loading: false,
        error: null
    }),

    getters: {
        getUser: (state) => state.user,
        isLoggedIn: (state) => state.isAuthenticated,
        isLoading: (state) => state.loading,
        getError: (state) => state.error,



    },

    actions: {
        setUser(user) {
            this.user = user
        },
        shareLink: function () {
            return `https://t.me/share/url?url=&text=Забирай бесплатные гемы уже сегодня в новом кликере от разработчиков 👇\n\n ${this.refLink()}`
        },
        refLink() {
            return `https://t.me/brawlcoin_robot?start=${this.user.tg_id}`
        },
        copyRefLink() {
            console.log(this.refLink())
            navigator.clipboard.writeText(this.refLink())
        },

        async fetchUser() {
            try {
                this.loading = true
                const response = await axios.get('/api/user')
                this.user = response.data
                this.isAuthenticated = true
            } catch (error) {
                this.error = error.response?.data?.message || 'Ошибка получения данных пользователя'
                this.user = null
                this.isAuthenticated = false
                throw error
            } finally {
                this.loading = false
            }
        },

        addCoins(coins) {
            this.user.coins = parseInt(this.user.coins) + parseInt(coins)
        },

        addEnergy(energy) {
            this.user.energy = parseInt(this.user.energy) + parseInt(energy)
        },

        removeEnergy(energy) {
            this.user.energy = parseInt(this.user.energy) - parseInt(energy)
        },

        async buyBoost(boost_id) {
            this.loading = true
            const response = await axios.post('/boost/buy', { boost_id })
            this.loading = false
            return response.data
        },
        async checkСompliance(task_id) {
            this.loading = true
            const response = await axios.post('/task/check', { task_id })
            this.loading = false
            return response.data
        },

        async creditingTap(tap_count) {

            const response = await axios.post('/tap', { tap_count })
            this.user.energy = parseInt(response.data.energy)
            this.user.coins = parseInt(response.data.coins)
        }

    }
})
