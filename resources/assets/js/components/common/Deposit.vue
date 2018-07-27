<template>
    <div class="deposit-wrap">
        <div v-if="paymentStatus">
            <div class="text-center">
                <div v-if="paymentStatus === 'paymentSuccess'">
                    <i class="fa fa-check fa-5x text-success" aria-hidden="true"></i>
                    <h3 style="font-weight: 100">Payment Success</h3>
                    <h5 class="mt-3">Your payment was processed successfully.</h5>
                    <h5>As this is your first deposit you got a free bonus from us.</h5>
                    <b-button class="mt-4" variant="success" @click="resetForm">
                        <span>Continue</span>
                    </b-button>
                    <div class="row justify-content-center mt-5">
                        <p class="col-md-8">
                            <strong>Congratulations!</strong> As a depositing user you're eligible for the Weekly Depositors' Freeroll where you can win entry tickets to a tournament with $5,000 in prizes.
                        </p>
                        <p class="col-md-8 mt-3">
                            To make sure you receive your email please check your email address is valid and you haven't opted out receiving emails from us.
                        </p>
                        <p class="col-md-8 mt-3">
                            All deposits bonuses are paid into your Pending Bonus account.
                        </p>
                    </div>
                </div>
                <div v-else>
                    <i class="fa fa-exclamation-circle fa-5x text-danger" aria-hidden="true"></i>
                    <h3 style="font-weight: 100">Payment Failed</h3>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="back-button">
                <b-button variant="outline-secondary" v-if="step !== 1" @click="step--">
                    <i class="fa fa-chevron-left"></i>
                    <span>Back</span>
                </b-button>
            </div>
            <form @submit.prevent="nextStep">
                <div v-if="step === 1">
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Deposit Amount</label>
                            <b-input-group :prepend="formattedCurrency">
                                <b-form-input v-model="amount" :state="hasError('amount')" min="250" type="number"></b-form-input>
                                <b-form-invalid-feedback>
                                    {{errors.amount}}
                                </b-form-invalid-feedback>
                            </b-input-group>
                        </div>
                    </div>
                </div>
                <div v-if="step === 2">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>First Name</label>
                            <b-form-input v-model="user.first_name" :state="hasError('first_name')"></b-form-input>
                            <b-form-invalid-feedback>
                                {{errors.first_name}}
                            </b-form-invalid-feedback>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Last Name</label>
                            <b-form-input v-model="user.last_name" :state="hasError('last_name')"></b-form-input>
                            <b-form-invalid-feedback>
                                {{errors.last_name}}
                            </b-form-invalid-feedback>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <b-form-input v-model="user.email" :state="hasError('email')" disabled="disabled"></b-form-input>
                            <b-form-invalid-feedback>
                                {{errors.email}}
                            </b-form-invalid-feedback>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Phone</label>
                            <b-form-input v-model="user.phone" :state="hasError('phone')"></b-form-input>
                            <b-form-invalid-feedback>
                                {{errors.address1}}
                            </b-form-invalid-feedback>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Country</label>
                            <b-form-select id="country" v-model="user.country" :options="countries" :state="hasError('country')" @input="showStates"/>
                            <b-form-invalid-feedback>
                                {{errors.country}}
                            </b-form-invalid-feedback>
                        </div>
                        <div class="form-group col-md-6" v-if="countryStates.length">
                            <label>State</label>
                            <b-form-select id="country" v-model="user.state" :options="countryStates" :state="hasError('state')">
                                <template slot="first">
                                    <option :value="null" disabled>Please select state</option>
                                </template>
                            </b-form-select>
                            <b-form-invalid-feedback>
                                {{errors.state}}
                            </b-form-invalid-feedback>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>City</label>
                            <b-form-input v-model="user.city" :state="hasError('city')"></b-form-input>
                            <b-form-invalid-feedback>
                                {{errors.city}}
                            </b-form-invalid-feedback>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Address</label>
                            <b-form-input v-model="user.address1" :state="hasError('address1')"></b-form-input>
                            <b-form-invalid-feedback>
                                {{errors.address1}}
                            </b-form-invalid-feedback>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Zip</label>
                            <b-form-input v-model="user.zip_code" :state="hasError('zip_code')"></b-form-input>
                            <b-form-invalid-feedback>
                                {{errors.zip_code}}
                            </b-form-invalid-feedback>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Currency</label>
                            <b-form-input v-model="user.currency" :state="hasError('currency')" disabled="disabled"></b-form-input>
                            <b-form-invalid-feedback>
                                {{errors.currency}}
                            </b-form-invalid-feedback>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col text-right">
                        <b-button variant="success" @click.prevent="nextStep">
                            <span v-html="stepLabel"></span>
                        </b-button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                step: 1,
                errors: {},
                amount: 250,
                countries: [],
                countryStates: []
            }
        },
        mounted() {
            this.getCountries();
        },
        methods: {
            getCountries() {
                axios.get('api/countries').then((response) => {
                    this.countries = _.map(response.data, (country) => {
                        return {text: country.name, value: country.code, states: country.states};
                    });
                });
            },
            getFormUrl() {
                let request = Object.assign({}, this.user, {amount: this.amount, client_orderid: this.generateGuid()});
                axios.post('api/payment-form', request).then((response) => {
                    // if (response.data.hasOwnProperty('form')) {
                    //     window.location.href = response.data.form;
                    // }
                }).catch(error => {
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
                    this.scrollToTop();
                });
            },
            showStates() {
                let country = _.find(this.countries, {value: this.user.country});
                let states = [];
                if (country && country.hasOwnProperty('states') && country.states.length > 0) {
                    states = _.map(country.states, (state) => {
                        return {text: state.state_name, value: state.state_code};
                    });
                }
                this.countryStates = states;
            },
            nextStep() {
                this.errors = {};
                switch (this.step) {
                    case 1:
                        if (!this.amount) {
                            this.$set(this.errors, 'amount', 'The amount field is required.');
                        } else if (parseInt(this.amount) < 250) {
                            this.$set(this.errors, 'amount', 'The amount field should be minimum 250.');
                        } else {
                            this.step++;
                        }
                        break;
                    case 2:
                        this.getFormUrl();
                }
            },
            resetForm() {
                this.$router.replace('my-account#deposit');
                this.step = 1;
            },
            generateGuid() {
                return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                    return v.toString(16);
                });
            },
            hasError(key) {
                return !this.errors.hasOwnProperty(key) ? null : false;
            },
            scrollToTop() {
                $('html, body').animate({scrollTop:0}, 'slow');
            }
        },
        watch: {
            user() {
                this.showStates();
            }
        },
        computed: {
            stepLabel() {
                switch (this.step) {
                    case 1:
                        return 'Next <i class="fa fa-chevron-right"></i>';
                    case 2:
                        return 'Proceed'
                }
            },
            user() {
                return Object.assign({}, this.$store.getters.getUser);
            },
            paymentStatus() {
                return this.$route.query.hasOwnProperty('action') ? this.$route.query.action : false;
            },
            formattedCurrency() {
                switch (this.user.currency) {
                    case 'EUR':
                        return '&euro;';
                    case 'GBP':
                        return '&pound;';
                    case 'USD':
                    default:
                        return '$';
                }
            },
        },
        name: "deposit"
    }
</script>

<style scoped>
    .deposit-wrap {
        min-height: 600px;
    }

    .back-button {
        align-items: center;
        height: 50px;
    }
</style>