<template>
    <form novalidate class="form-wrapper" @submit.prevent="submitForm">
        <div class="alert" :class="{'alert-success': success, 'alert-danger': !success}" v-if="message" v-html="message"></div>
        <h4 v-if="!sent">Please enter your email and we'll send you instructions on how to reset your password.</h4>
        <div v-if="!sent" class="form-group">
            <b-form-input type="email" v-model="form.email" placeholder="Email" :state="hasError('email')"></b-form-input>
            <b-form-invalid-feedback>
                {{errors.email}}
            </b-form-invalid-feedback>
        </div>
        <div v-if="!sent" class="captcha-wrapper form-group">
            <div class="d-flex justify-content-between align-items-start">
                <img :src="captchaUrl" alt="Captcha" @click="getCaptcha">
                <button class="btn" type="button" @click="getCaptcha"><i class="fa fa-refresh"></i></button>
            </div>
            <b-form-input type="text" v-model="form.captcha" placeholder="Enter code above here" :state="hasError('captcha')"></b-form-input>
            <b-form-invalid-feedback>
                {{errors.captcha}}
            </b-form-invalid-feedback>
        </div>
        <div v-if="!sent">
            <b-button variant="success" size="lg" type="submit">Submit</b-button>
        </div>
    </form>
</template>

<script>
    export default {
        name: "forgot-password",
        data() {
            return {
                captchaUrl: null,
                form: {
                    email: null,
                    captcha: null,
                    captcha_key: null
                },
                errors: {},
                success: true,
                message: null,
                sent: false,
            }
        },
        mounted() {
            this.getCaptcha();
        },
        methods: {
            getCaptcha() {
                axios.get('/api/captcha').then((result) => {
                    if (result.data.hasOwnProperty('img')) {
                        this.captchaUrl = result.data.img;
                    }
                    if (result.data.hasOwnProperty('key')) {
                        this.form.captcha_key = result.data.key;
                    }
                })
            },
            submitForm() {
                this.errors = {};
                this.message = null;
                axios.post("/api/forgot", this.form).then((result) => {
                    this.success = this.sent = true;
                    if (result.data.hasOwnProperty('message')) {
                        this.message = result.data.message;
                    }
                    this.form.email = this.form.captcha = null;
                    this.getCaptcha();
                }).catch((error) => {
                    this.success = false;
                    let errorResponse = error.response.data;
                    if (errorResponse.hasOwnProperty('errors')) {
                        this.errors = _.reduce(errorResponse.errors, function(result, value, key) {
                            result[key] = _.head(value);
                            return result;
                        }, {});
                    } else {
                        if (errorResponse.hasOwnProperty('message')) {
                            this.message = errorResponse.message;
                        }
                    }
                })
            },
            hasError(key) {
                return !this.errors.hasOwnProperty(key) ? null : false;
            }
        }
    }
</script>

<style scoped>
    .captcha-wrapper {
        padding: 10px;
        background-color: #f9f9f9;
        border: 1px solid #e4e4e4;
        border-radius: 0.25rem;
    }
    .captcha-wrapper img {
        margin-bottom: 10px;
    }
</style>