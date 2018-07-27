<template>
    <form novalidate class="form-wrapper" @submit.prevent="submitForm">
        <div class="alert" :class="{'alert-success': success, 'alert-danger': !success}" v-if="message" v-html="message"></div>
        <h4>Please enter your new password.</h4>
        <div class="form-group">
            <b-form-input type="password" v-model="form.password" placeholder="Password" :state="hasError('password')"></b-form-input>
            <b-form-invalid-feedback>
                {{errors.password}}
            </b-form-invalid-feedback>
        </div>
        <div class="form-group">
            <b-form-input type="password" v-model="form.password_confirmation" placeholder="Confirm Password"></b-form-input>
        </div>
        <div>
            <b-button variant="success" size="lg" type="submit">Submit</b-button>
        </div>
    </form>
</template>

<script>
    export default {
        name: "reset-password",
        data() {
            return {
                form: {
                    password: null,
                    password_confirmation: null,
                    token: null,
                },
                errors: {},
                message: null,
                success: true
            }
        },
        mounted() {
            if (this.$route.query.hasOwnProperty('token')) {
                this.form.token = this.$route.query.token;
            }
        },
        methods: {
            submitForm() {
                this.errors = {};
                this.message = null;
                axios.post('/api/reset-password', this.form).then((result) => {
                    this.success = true;
                    if (result.data.hasOwnProperty('message')) {
                        this.message = result.data.message;
                    }
                }).catch((error) => {
                    let errorResponse = error.response.data;
                    if (errorResponse.hasOwnProperty('errors')) {
                        this.errors = _.reduce(errorResponse.errors, function(result, value, key) {
                            result[key] = _.head(value);
                            return result;
                        }, {});
                    } else {
                        if (errorResponse.hasOwnProperty('message')) {
                            this.success = false;
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

</style>