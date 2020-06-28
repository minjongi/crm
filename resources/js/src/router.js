/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import Vue from 'vue'
import Router from 'vue-router'
import axios from "@/axios.js"
import store from '@/store/store'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    scrollBehavior () {
        return { x: 0, y: 0 }
    },
    routes: [

        {
    // =============================================================================
    // MAIN LAYOUT ROUTES
    // =============================================================================
            path: '',
            component: () => import('./layouts/main/Main.vue'),
            children: [
        // =============================================================================
        // Theme Routes
        // =============================================================================
              {
                path: '/',
                name: 'home',
                    component: () => import('./views/Home.vue'),
                    meta: {
                        authRequired: true,
                    }
                },
                {
                    path: '/board',
                    name: 'board',
                    component: () => import('./views/board/List.vue'),
                    meta: {
                        authRequired: true,
                    }
                },
                {
                    path: '/board/reg',
                    name: 'board-reg',
                    component: () => import('./views/board/Reg.vue'),
                    meta: {
                        authRequired: true,
                    }
              },
              {
                    path: '/board/view',
                    name: 'board-view',
                    component: () => import('./views/board/View.vue'),
                    meta: {
                        authRequired: true,
                    }
              },
            ],
        },
    // =============================================================================
    // FULL PAGE LAYOUTS
    // =============================================================================
        {
            path: '',
            component: () => import('@/layouts/full-page/FullPage.vue'),
            children: [
        // =============================================================================
        // PAGES
        // =============================================================================
              {
                path: '/pages/login',
                name: 'page-login',
                    component: () => import('@/views/pages/Login.vue'),
                    meta: {
                        authRequired: false,
                    }
                },
                {
                    path: '/pages/register',
                    name: 'page-register',
                    component: () => import('@/views/register/Register.vue'),
                    meta: {
                        authRequired: false,
                    }
              },
              {
                path: '/pages/error-404',
                name: 'page-error-404',
                    component: () => import('@/views/pages/Error404.vue'),
                    meta: {
                        authRequired: true,
                    }
              },
            ]
        },
        {
            path: '/logout',
            name: 'logout',
            component: {
                template: '<p></p>',
                created() {
                    axios.post('/api/logout').then(response => {
                        location.replace('/pages/login')
                    })
                }
            },
            meta: {
                authRequired: false,
            }
        },
        // Redirect to 404 page, if no match found
        {
            path: '*',
            redirect: '/pages/error-404'
        }
    ],
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(function(routeInfo) { return routeInfo.meta.authRequired; })) {
        store.dispatch('auth/chkSession')
    }
    next();
})

router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')

    if (appLoading) {
        appLoading.style.display = "none";
    }
})

export default router
