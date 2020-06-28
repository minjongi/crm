import state from './moduleBoardState.js'
import mutations from './moduleBoardMutations.js'
import actions from './moduleBoardActions.js'
import getters from './moduleBoardGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state: state,
  mutations: mutations,
  actions: actions,
  getters: getters
}
