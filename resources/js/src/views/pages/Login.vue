<!-- =========================================================================================
    File Name: Login.vue
    Description: Login Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <div class="h-screen flex w-full bg-img vx-row no-gutter items-center justify-center" id="page-login">
        <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-3/4 xl:w-3/5 sm:m-0 m-4">
            <vx-card>
                <div slot="no-body" class="full-page-bg-color">
                    <div class="vx-row no-gutter justify-center items-center">
                        <div class="vx-col hidden lg:block lg:w-1/2">
                            <img src="@assets/images/pages/login.png" alt="login" class="mx-auto">
                        </div>
                        <div class="vx-col sm:w-full md:w-full lg:w-1/2 d-theme-dark-bg">
                            <div class="p-8 login-tabs-container">
                                <div class="vx-card__title mb-4">
                                    <h4 class="mb-4">Login</h4>
                                    <p>Welcome back, please login to your account.</p>
                                </div>
                                <div>
                                    <vs-input
                                            name="name"
                                            icon-no-border
                                            icon="icon icon-user"
                                            icon-pack="feather"
                                            label-placeholder="ID"
                                            v-model="name"
                                            v-validate="'required'"
                                            v-on:keyup.enter="login"
                                            class="w-full"/>
                                    <span class="text-danger text-sm" v-show="errors.has('name')">{{ errors.first('name') }}</span>
                                    <vs-input
                                            type="password"
                                            name="password"
                                            icon-no-border
                                            icon="icon icon-lock"
                                            icon-pack="feather"
                                            label-placeholder="Password"
                                            v-model="password"
                                            v-validate="'required'"
                                            v-on:keyup.enter="login"
                                            class="w-full mt-6"/>
                                    <span class="text-danger text-sm" v-show="errors.has('password')">{{ errors.first('password') }}</span>
                                    <div class="my-5 text-center">
                                        <vs-button class="" @click="login">Login</vs-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </vx-card>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import VeeValidate, {Validator} from 'vee-validate'
    import KoreanValidate from 'vee-validate/dist/locale/ko'

    export default {
        data() {
            return {
                name: "",
                password: "",
                checkbox_remember_me: false,
                possible_register: false,
            }
        },
        created() {
            KoreanValidate['attributes'] = Object.assign(
                KoreanValidate['attributes'],
                Object({
                    name: '아이디 ',
                    password: '패스워드 ',
                })
            )

            Validator.localize('ko', KoreanValidate)
            // dictionary 속성에 넘겨주면 끝!
            Vue.use(VeeValidate, {locale: KoreanValidate})
        },
        methods: {
            login() {
                this.$validator.validateAll().then(result => {
                    if (result) {
                        const payload = {
                            name: this.name,
                            password: this.password,
                            checkbox_remember_me: this.checkbox_remember_me,
                            notify: this.$vs.notify
                        }
                        this.$store.dispatch('auth/login', payload)
                    }
                })
            },
            register() {
                this.$router.push({name: 'page-register'})
            }
        }
    }
</script>

<style lang="scss">
    #page-login {
        .social-login-buttons {
            .bg-facebook {
                background-color: #1551b1
            }

            .bg-twitter {
                background-color: #00aaff
            }

            .bg-google {
                background-color: #4285F4
            }

            .bg-github {
                background-color: #333
            }
        }
    }
</style>
