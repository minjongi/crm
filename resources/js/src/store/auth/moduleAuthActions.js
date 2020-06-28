/*=========================================================================================
  File Name: moduleAuthActions.js
  Description: Auth Module Actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import axios from "@/axios.js"

export default {
    registerUser({commit}, payload) {
        axios.post('/api/register', payload.userDetails)
            .then(response => {
                if (response.data.status === 'success') {
                    commit('setUser', response.data.data)
                    location.replace('/')
                }
            }).catch(error => {
                payload.notify({
                    title: '회원가입 실패',
                    text: error.response.data.data.message,
                    iconPack: 'feather',
                    icon: 'icon-alert-circle',
                    color: 'danger'
                })
        })
    },
    login({commit}, payload) {
        let params = {
            email: payload.email,
            password: payload.password,
        }

        axios.post('/api/login', params).then(response => {
            if (response.data.status == 'success') {
                commit('setUser', response.data.data)
                location.replace('/')
            }
        }).catch(error => {
            payload.notify({
                title: '로그인 실패',
                text: error.response.data.data.message,
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: 'danger'
            })
        })
    },
    logout({commit}) {
        axios.post('/api/logout').then(response => {
            commit('setUser', {})
            location.replace('/pages/login')
        })
    },
    chkSession({commit}) {
        return new Promise((resolve, reject) => {
            axios.get("/api/session")
                .then(response => {
                    commit('setUser', response.data.data)
                    resolve(response)
                })
                .catch(error => {
                    reject(error)
                })
        })
    },
}
