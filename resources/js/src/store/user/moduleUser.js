/*=========================================================================================
  File Name: moduleUser.js
  Description: Calendar Module
  ----------------------------------------------------------------------------------------
  Item Name: member store
  Author: dhseo
==========================================================================================*/


import state from './moduleUserState.js'
import mutations from './moduleUserMutations.js'
import actions from './moduleUserActions.js'
import getters from './moduleUserGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state: state,
  mutations: mutations,
  actions: actions,
  getters: getters
}

