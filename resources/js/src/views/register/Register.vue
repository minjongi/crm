<!-- =========================================================================================
    File Name: Register.vue
    Description: Register Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <div class="h-screen flex w-full bg-img vx-row no-gutter items-center justify-center">
        <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-3/4 xl:w-3/5 sm:m-0 m-4">
            <vx-card>
                <div slot="no-body" class="full-page-bg-color">
                    <div class="vx-row no-gutter">
                        <div class="vx-col hidden sm:hidden md:hidden lg:block lg:w-1/2 mx-auto self-center">
                            <img src="@assets/images/pages/register.jpg" alt="register" class="mx-auto">
                        </div>
                        <div class="vx-col sm:w-full md:w-full lg:w-1/2 mx-auto self-center  d-theme-dark-bg">
                            <div class="px-8 pt-8 register-tabs-container">
                                <div class="vx-card__title mb-4">
                                    <h4 class="mb-4">Create Account</h4>
                                    <p>Fill the below form to create a new account.</p>
                                </div>
                                <div class="clearfix">
                                    <vs-input
                                        v-validate="'required|alpha_dash|min:3'"
                                        data-vv-validate-on="blur"
                                        label-placeholder="Name"
                                        name="displayName"
                                        placeholder="Name"
                                        v-model="displayName"
                                        class="w-full" />
                                    <span class="text-danger text-sm">{{ errors.first('displayName') }}</span>

                                    <vs-input
                                        v-validate="'required|email'"
                                        data-vv-validate-on="blur"
                                        name="email"
                                        type="email"
                                        label-placeholder="Email"
                                        placeholder="Email"
                                        v-model="email"
                                        class="w-full mt-6" />
                                    <span class="text-danger text-sm">{{ errors.first('email') }}</span>

                                    <vs-input
                                        ref="password"
                                        type="password"
                                        data-vv-validate-on="blur"
                                        v-validate="'required|min:8|max:20'"
                                        name="password"
                                        label-placeholder="Password"
                                        placeholder="Password"
                                        v-model="password"
                                        class="w-full mt-6" />
                                    <span class="text-danger text-sm">{{ errors.first('password') }}</span>

                                    <vs-input
                                        type="password"
                                        v-validate="'min:6|max:10|confirmed:password'"
                                        data-vv-validate-on="blur"
                                        data-vv-as="password"
                                        name="confirm_password"
                                        label-placeholder="Confirm Password"
                                        placeholder="Confirm Password"
                                        v-model="confirm_password"
                                        class="w-full mt-6" />
                                    <span class="text-danger text-sm">{{ errors.first('confirm_password') }}</span>

                                    <vs-button  type="border" to="/pages/login" class="mt-6">Login</vs-button>
                                    <vs-button class="float-right mt-6" @click="registerUser" :disabled="!validateForm">Register</vs-button>
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
export default {
    data() {
        return {
            displayName: '',
            email: '',
            password: '',
            confirm_password: '',
            isTermsConditionAccepted: true
        }
    },
    computed: {
        validateForm() {
            return !this.errors.any() && !!this.displayName && !!this.email && !!this.password && !!this.confirm_password
        }
    },
    methods: {
        registerUser() {
            // If form is not validated or user is already login return
            if (!this.validateForm) return

            const payload = {
                userDetails: {
                    name: this.displayName,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.confirm_password
                },
                notify: this.$vs.notify
            }
            this.$store.dispatch('auth/registerUser', payload)
        }
    }
}
</script>

<style lang="scss">
.register-tabs-container {
  min-height: 517px;

  .con-tab {
    padding-bottom: 23px;
  }
}
</style>
