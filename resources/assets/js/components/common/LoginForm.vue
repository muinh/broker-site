<template>
    <div>
        <div class="d-none notLoggedIn">
            <form class="d-flex" id="loginForm" @submit.prevent="submitLogin">
                <span class="mt-2 mr-2 text-white">LOGIN:</span>
                <div class="ui form-field style-default size-sm mr-1">
                    <input type="email" v-model="form.username" placeholder="Email" required>
                </div>
                <div class="ui form-field style-default size-sm mr-1">
                    <input type="password" v-model="form.password" placeholder="Password" required>
                </div>
                <button class="btn btn-bottom">
                    <i class="fa fa-send"></i>
                </button>
            </form>
            <div class="d-flex" style="margin-left: 52px;">
                <router-link to="/forgot-password" class="forgot-password">Forgot Your Password?</router-link>
            </div>
        </div>
        <div class="d-none loggedIn">
            <div class="d-flex align-items-center">
                <span class="userInfo">
                    <span>Welcome:</span>
                    <span class="userName">{{ userName }}</span>
                    <span>Balance:</span>
                    <span class="userBalance"><span class="text-success">{{ formatBalance }}</span></span>
                </span>
                <button type="button" class="ui button style-default" @click.prevent="logOut">Logout</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "login-form",
        data() {
            return {
                showLogin: 'none',
                showStatus: 'none',
                form : {
                    username: null,
                    password: null
                }
            }
        },
        mounted() {
            this.$store.dispatch('checkAuth');
        },
        methods: {
            submitLogin() {
                let loginData = Object.assign({}, this.form, {brokerName: this.platformSettings.brokerName});
                axios.post(this.platformSettings.baseUrl + 'auth/login', loginData).then((response) => {
                    if (response.data.token !== undefined) {
                        axios.post('https://cashier.cfsum.com/api/praxis-auth/get-praxis-token', {token: response.data.token}).then((praxisResponse) => {
                            if (praxisResponse.data.hasOwnProperty('Secret')) {
                                createCookie('BX8Trader-Auth', response.data.token, 1, '/', this.platformSettings.cookieDomain);
                                createCookie('Praxis-Auth', JSON.stringify(praxisResponse.data), 1, '/', this.platformSettings.cookieDomain);
                                this.$store.dispatch('checkAuth');
                                this.$router.push('/my-account#deposit');
                            }
                        }).catch(() => {
                            swal("Whoops something went wrong", "Try again later!", "error");
                        });
                        // createCookie('BX8Trader-Auth', response.data.token, 1, '/', this.platformSettings.cookieDomain);
                        // this.$store.dispatch('checkAuth');
                        // this.$router.push('/my-account#deposit');
                    }
                }).catch((error) => {
                    if (error.response.status === 401) {
                        swal("Whoops something went wrong", "E-mail or password are incorrect!", "error");
                    }
                });
            },
            logOut() {
                axios.post('/api/logout').then(() => {
                    document.cookie = `BX8Trader-Auth=; path=/;domain=${this.platformSettings.cookieDomain};expires=Thu, 01 Jan 1970 00:00:01 GMT`;
                    this.$store.dispatch('checkAuth');
                })
            },
        },
        computed: {
            formatBalance() {
                let options = { style: 'currency', currency: this.$store.state.user.currency };
                let numberFormat = new Intl.NumberFormat('en-US', options);
                return numberFormat.format(this.$store.state.user.accountBalance);
            },
            userName() {
                return [this.$store.state.user.FirstName, this.$store.state.user.LastName].join(' ');
            },
            platformSettings() {
                return window.baseSettings.platform;
            },
            isAuthenticated() {
                return this.$store.state.authenticated;
            }
        }
    }
</script>

<style>
    .userInfo {
        color: #fff;
        margin-right: 10px;
    }
    .userName, .userBalance {
        font-weight: bold;
        margin: 0 5px;
    }
    .staggered-transition {
        transition: all .5s ease;
        overflow: hidden;
        margin: 0;
        height: 20px;
    }
    .staggered-enter, .staggered-leave {
        opacity: 0;
        height: 0;
    }
</style>