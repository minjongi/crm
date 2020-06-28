import axios from "@/axios.js"

export default {
    list({ commit, state }, params) {
        return new Promise((resolve, reject) => {
            params.params.per_page = state.paginationPageSize
            params.params.page = state.currentPage
            axios.get("/api/boards", params)
                .then(response => {
                    commit('setListData', response.data.data)
                    resolve(response.data.data)
                })
                .catch(error => {
                    console.log(error)
                    reject(error)
                })
        })
    },
    get({commit}, id) {
        commit("setBoard", {id: id})
        return new Promise((resolve, reject) => {
            axios.get("/api/boards/" + id)
                .then(response => {
                    commit('setBoard', response.data.data)
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
            axios.post("/api/boards", params)
                .then(response => {
                    commit('setBoard', response.data.data)
                    resolve(response.data.data)
                })
                .catch(error => {
                    console.log(error)
                    reject(error)
                })
        })
    },
    update({commit}, params) {
        return new Promise((resolve, reject) => {
            axios.put("/api/boards/" + params.params.id, params)
                .then(response => {
                    commit('setBoard', response.data.data)
                    resolve(response.data.data)
                })
                .catch(error => {
                    console.log(error)
                    reject(error)
                })
        })
    },
    delete({commit}, id) {
        return new Promise((resolve, reject) => {
            axios.delete("/api/boards/" + id)
                .then(response => {
                    commit('setBoard', {})
                    resolve(response.data.data)
                })
                .catch(error => {
                    console.log(error)
                    reject(error)
                })
        })
    }
}
