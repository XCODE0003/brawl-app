import { defineStore } from 'pinia'
import axios from 'axios'

export const useTaskStore = defineStore('task', {
    state: () => ({
        user: null,
        isAuthenticated: false,
        loading: false,
        error: null,
        tasks_daily: [],
        tasks: []
    }),

    getters: {
        getUser: (state) => state.user,
        isLoggedIn: (state) => state.isAuthenticated,
        isLoading: (state) => state.loading,
        getError: (state) => state.error

    },

    actions: {
        setTasks(tasks_daily, tasks) {
            this.tasks_daily = tasks_daily
            this.tasks = tasks
        },

        removeTaskFromLists(task_id) {
            this.tasks = this.tasks.filter(task => task.id !== task_id)
            this.tasks_daily = this.tasks_daily.filter(task => task.id !== task_id)
        }
    }
})
