<template>
    <div class="my-account-wrap">
        <b-tabs v-model="currentTab">
            <b-tab title="Deposit/Withdraw">
                <!--<deposit></deposit>-->
                <iframe src="https://cfsum.cfsum.com/Praxis" frameborder="0" class="depositIFrame">Test</iframe>
                <!--<iframe src="data:text/html;base64,PGgzIHN0eWxlPSJmb250LWZhbWlseTphcmlhbCxzYW5zLXNlcmlmO3RleHQtYWxpZ246Y2VudGVyO21hcmdpbjo1MHB4IDAiPlByYXhpcyBJRnJhbWU8L2gzPg==" frameborder="0" class="depositIFrame">Test</iframe>-->
            </b-tab>
            <b-tab title="Personal Details">
                <form class="my-account-form container p-0">
                    <div v-if="loading" class="loader-wrapper">
                        <loader></loader>
                    </div>
                    <div class="d-flex">
                        <div class="col-md-6 align-items-center py-2 form-group row">
                            <label class="col-sm-4 col-form-label">
                                <strong>First Name</strong>
                            </label>
                            <div class="col-sm-8">
                                <b-form-input v-if="edit" type="text" id="firstName" :state="hasError('FirstName')" v-model="user.FirstName"></b-form-input>
                                <span class="details-row" v-else>{{user.FirstName || empty}}</span>
                                <b-form-invalid-feedback>
                                    {{errors.FirstName}}
                                </b-form-invalid-feedback>
                            </div>
                        </div>
                        <div class="col-md-6 align-items-center py-2 form-group row">
                            <label class="col-sm-4 col-form-label">
                                <strong>Last Name</strong>
                            </label>
                            <div class="col-sm-8">
                                <b-form-input v-if="edit" type="text" id="lastName" :state="hasError('LastName')" v-model="user.LastName"></b-form-input>
                                <span class="details-row" v-else>{{user.LastName || empty}}</span>
                                <b-form-invalid-feedback>
                                    {{errors.LastName}}
                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="col-md-6 align-items-center py-2 form-group row">
                            <label for="email" class="col-sm-4 col-form-label">
                                <strong>Email</strong>
                            </label>
                            <div id="email" class="col-sm-8">
                                <span class="details-row">{{user.email || empty}}</span>
                            </div>
                        </div>
                        <div class="col-md-6 align-items-center py-2 form-group row">
                            <label class="col-sm-4 col-form-label">
                                <strong>Phone</strong>
                            </label>
                            <div class="col-sm-8">
                                <b-form-input v-if="edit" type="text" id="phone" :state="hasError('phone')" v-model="user.phone"></b-form-input>
                                <span class="details-row" v-else>{{user.phone || empty}}</span>
                                <b-form-invalid-feedback>
                                    {{errors.phone}}
                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="col-md-6 align-items-center py-2 form-group row">
                            <label class="col-sm-4 col-form-label">
                                <strong>Country</strong>
                            </label>
                            <div class="col-sm-8">
                                <b-form-select v-if="edit" id="country" v-model="user.country" :state="hasError('country')" :options="countries"/>
                                <span v-else>
                                    <span class="details-row" v-if="selectedCountry">{{selectedCountry.text || empty}}</span>
                                </span>
                                <b-form-invalid-feedback>
                                    {{errors.country}}
                                </b-form-invalid-feedback>
                            </div>
                        </div>
                        <div class="col-md-6 align-items-center py-2 form-group row">
                            <label class="col-sm-4 col-form-label">
                                <strong>City</strong>
                            </label>
                            <div class="col-sm-8">
                                <b-form-input v-if="edit" type="text" id="city" :state="hasError('City')" v-model="user.City"></b-form-input>
                                <span class="details-row" v-else>{{user.City || empty}}</span>
                                <b-form-invalid-feedback>
                                    {{errors.City}}
                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="col-md-6 align-items-center py-2 form-group row">
                            <label class="col-sm-4 col-form-label">
                                <strong>Street</strong>
                            </label>
                            <div class="col-sm-8">
                                <b-form-input v-if="edit" type="text" id="street" :state="hasError('Street')" v-model="user.Street"></b-form-input>
                                <span class="details-row" v-else>{{user.Street || empty}}</span>
                                <b-form-invalid-feedback>
                                    {{errors.Street}}
                                </b-form-invalid-feedback>
                            </div>
                        </div>
                        <div class="col-md-6 align-items-center py-2 form-group row">
                            <label class="col-sm-4 col-form-label">
                                <strong>State</strong>
                            </label>
                            <div class="col-sm-8">
                                <b-form-input v-if="edit" type="text" id="state" :state="hasError('state')" v-model="user.state"></b-form-input>
                                <span class="details-row" v-else>{{user.state || empty}}</span>
                                <b-form-invalid-feedback>
                                    {{errors.state}}
                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="col-md-6 align-items-center py-2 form-group row">
                            <label class="col-sm-4 col-form-label">
                                <strong>Verification Status</strong>
                            </label>
                            <div class="col-sm-8">
                                <span class="details-row">{{user.VerificationStatus || empty}}</span>
                            </div>
                        </div>
                        <div class="col-md-6 align-items-center py-2 form-group row">
                            <label class="col-sm-4 col-form-label">
                                <strong>Postal Code</strong>
                            </label>
                            <div class="col-sm-8">
                                <b-form-input v-if="edit" type="text" id="zip" :state="hasError('PostalCode')" v-model="user.PostalCode"></b-form-input>
                                <span class="details-row" v-else>{{user.PostalCode || empty}}</span>
                                <b-form-invalid-feedback>
                                    {{errors.PostalCode}}
                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </div>
                    <div class="form-row pt-3">
                        <div class="form-group co ml-3">
                            <b-button v-if="!edit" variant="secondary" @click.prevent="toggleEdit">
                                <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                            </b-button>
                            <b-button v-if="edit" variant="danger" @click.prevent="toggleEdit">
                                Cancel
                            </b-button>
                            <b-button v-if="edit" variant="success" @click.prevent="updateProfile">
                                Update profile
                            </b-button>
                        </div>
                    </div>
                </form>
            </b-tab>
        </b-tabs>
    </div>
</template>

<script>
    import Deposit from "./Deposit";
    import Circle from "vue-loading-spinner/src/components/Circle.vue";

    export default {
        components: {'loader': Circle, Deposit},
        name: "my-account",
        data() {
            return {
                empty: 'Empty',
                edit: false,
                errors: {},
            }
        },
        created() {
            this.$store.dispatch('getCountries');
        },
        methods: {
            updateProfile() {
                this.errors = {};
                axios.post('api/update', this.user).then(() => {
                    this.toggleEdit();
                    this.$store.dispatch('checkAuth');
                    this.$toastr.s('Profile updated successfully');
                }).catch((error) => {
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
                });
            },
            toggleEdit() {
                this.edit = !this.edit;
            },
            hasError(key) {
                return !this.errors.hasOwnProperty(key) ? null : false;
            },
        },
        computed: {
            loading() {
                return this.$store.state.loading;
            },
            user() {
                return Object.assign({}, this.$store.state.user);
            },
            countries() {
                return _.map(this.$store.state.countries, (country) => {
                    return {
                        text: country.name,
                        value: country.code.toUpperCase()
                    }
                });
            },
            selectedCountry() {
                return _.find(this.countries, [
                    'value', this.user.country,
                ])
            },
            currentTab: {
                get() {
                    switch (this.$route.hash) {
                        case '#deposit':
                            return 0;
                        case '#personalDetails':
                            return 1;
                    }
                },
                set(value) {
                    switch (value) {
                        case 0:
                            this.$router.push('#deposit');
                            break;
                        case 1:
                            this.$router.push('#personalDetails');
                            break;
                    }
                }
            }
        }
    }
</script>

<style scoped>
    .my-account-wrap {
        max-width: 700px;
        margin: 0 auto;
    }
    .my-account-form {
        position: relative;
        margin: 10px 0;
        min-height: 300px;
    }
    .depositIFrame {
        width: 100%;
        min-height: 600px;
    }
    .loader-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: 0;
        left:0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.1);
    }
    .details-row {
        padding: 0.375rem 0.75rem;
        font-size: 0.9rem;
        border: 1px solid transparent;
        line-height: 23.04px;
    }
</style>