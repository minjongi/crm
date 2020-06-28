/*=========================================================================================
  File Name: moduleCalendarActions.js
  Description: Calendar Module Actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import axios from "@/axios.js"

export default {
    get({commit}, userId) {
        commit("setUser", {id: userId})
        return new Promise((resolve, reject) => {
            axios.get("/api/user/" + userId)
                .then(response => {
                    console.log('axios', response)
                    commit('setUser', response.data.data)
                    resolve(response.data.data)
                })
                .catch(error => {
                    console.log(error)
                    reject(error)
                })
        })
    },
    create({commit}, params) {
        return new Promise((resolve, reject) => {
            axios.post("/api/user", params)
                .then(response => {
                    commit('setUser', response.data.data)
                    resolve(response.data.data)
                })
                .catch(error => {
                    reject(error)
                })
        })
    },
    getSession() {
        return new Promise((resolve, reject) => {
            axios.get("/api/session").then(response => {
                resolve(response)
            })
            .catch(error => {
                reject(error)
            })
        })
    }
}
