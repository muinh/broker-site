<template>
    <div>
        <div class="row">
            <div class="col-md-3">
                <iframe name="myfxbook_market" width="100%" height="290" scrolling="no" frameborder="0" allowtransparency="true" hspace="0" vspace="0" marginheight="0" marginwidth="0" src="https://widgets.myfxbook.com/widgets/market.html"></iframe>
                <br><br>
                <h2><i class="fa fa-phone-square mr-2"></i>Call us</h2>
                <small>
                    United Kingdom + 44 (20) 35147045
                </small>
                <br><br>
                <h2><i class="fa fa-envelope-square mr-2"></i>E-mail</h2>
                <small>
                    SUPPORT: <a href="mailto:support@cfsum.com">support@cfsum.com</a><br>
                    CFSum™ a brand of Bestfolio Consulting OU 14474546. The website is owned and operated by Bestfolio Consulting OU 14474546 Registered address Harju maakond Tallinn Kesklinna linnaosa Narva mnt 5 101 17 and located at Harju maakond Tallinn Kesklinna linnaosa Narva mnt 5 101 17.
                </small>
            </div>
            <div class="col-md-9">
                <form v-if="accessAllowed" novalidate="novalidate" class="form-wrapper" @submit.prevent="submitForm">
                    <div class="alert" :class="{'alert-success': success, 'alert-danger': !success}" v-if="message" v-html="message"></div>
                    <div class="form-group">
                        <label>First Name <span class="required">*</span></label>
                        <b-form-input type="text" :state="hasError('firstName')" v-model="form.firstName"></b-form-input>
                        <b-form-invalid-feedback>
                            {{errors.firstName}}
                        </b-form-invalid-feedback>
                    </div>
                    <div class="form-group">
                        <label>Last Name <span class="required">*</span></label>
                        <b-form-input type="text" :state="hasError('lastName')" v-model="form.lastName"></b-form-input>
                        <b-form-invalid-feedback>
                            {{errors.lastName}}
                        </b-form-invalid-feedback>
                    </div>
                    <div class="form-group">
                        <label>Phone <span class="required">*</span></label>
                        <b-form-input type="tel" :state="hasError('phone')" v-model="form.phone"></b-form-input>
                        <b-form-invalid-feedback>
                            {{errors.phone}}
                        </b-form-invalid-feedback>
                    </div>
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <b-form-input type="email" :state="hasError('email')" v-model="form.email"></b-form-input>
                        <b-form-invalid-feedback>
                            {{errors.email}}
                        </b-form-invalid-feedback>
                    </div>
                    <div class="form-group">
                        <label>Password <span class="required">*</span></label>
                        <b-form-input type="password" :state="hasError('password')" v-model="form.password"></b-form-input>
                        <b-form-invalid-feedback>
                            {{errors.password}}
                        </b-form-invalid-feedback>
                    </div>
                    <div class="form-group">
                        <label>Country <span class="required">*</span></label>
                        <b-form-select :state="hasError('country')" v-model="form.country" :options="countries"/>
                        <b-form-invalid-feedback>
                            {{errors.country}}
                        </b-form-invalid-feedback>
                    </div>
                    <div class="form-group">
                        <label>Currency <span class="required">*</span></label>
                        <b-form-select :state="hasError('currency')" v-model="form.currency" id="currency">
                            <option value="USD">$ USD</option>
                            <option value="EUR">€ EUR</option>
                            <option value="GBP">£ GBP</option>
                        </b-form-select>
                        <b-form-invalid-feedback>
                            {{errors.currency}}
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
                    <div class="form-group">
                        <b-form-checkbox v-model="form.terms" :state="hasError('terms')">Im over 18 years of age and I accept the <a href="/terms-and-conditions" target="_blank">terms &amp; conditions</a> <span class="required">*</span></b-form-checkbox>
                        <b-form-invalid-feedback>
                            {{errors.terms}}
                        </b-form-invalid-feedback>
                    </div>
                    <div class="form-group">
                        <b-form-checkbox v-model="form.gdpr" :state="hasError('gdpr')">I consent to having this website store my submitted information so they can respond to my inquiry <span class="required">*</span></b-form-checkbox>
                        <b-form-invalid-feedback>
                            {{errors.gdpr}}
                        </b-form-invalid-feedback>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg">Submit</button>
                </form>
                <div v-else :style="{display: block}">
                    <h4><strong>Sorry, registration for your country is restricted.</strong></h4>
                    <p style="font-size: 16px;">If you believe this is a mistake please contact our Customer Support at support@cfsum.com</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "register-form",
        data() {
            return {
                errors: {},
                success: true,
                message: null,
                form: {
                    firstName: null,
                    lastName: null,
                    phone: null,
                    email: null,
                    password: null,
                    currency: 'USD',
                    terms: false,
                    gdpr: false,
                    country: null,
                    captcha: null,
                    captcha_key: null,
                    AffiliateId: null
                },
                countries: [],
                accessAllowed: false,
                captchaUrl: null,
                block: 'none'
            }
        },
        mounted() {
            this.isAccessAllowed();
            this.getCaptcha();
            if (this.$route.query.hasOwnProperty('affiliate')){
                this.form.AffiliateId = this.$route.query.affiliate;
            }
            this.getCountries();
        },
        methods: {
            getCountries() {
                axios.get('/api/geo').then((result) => {
                    if (result.data.hasOwnProperty('countries')) {
                        this.countries = _.map(result.data.countries, (country) => {
                            return {text: country.name, value: country.iso};
                        });
                    }
                    if (result.data.hasOwnProperty('iso')) {
                        this.form.country = result.data.iso;
                    }
                    if (result.data.hasOwnProperty('prefix')) {
                        this.form.phone = result.data.prefix;
                    }
                });
            },
            submitForm() {
                this.errors = {};
                this.success = true;
                this.trimPlusSign();
                axios.post('/api/register', this.form).then((result) => {
                    if (result.data.token !== false) {
                        createCookie('BX8Trader-Auth', result.data.token, 1, '/', this.platformSettings.cookieDomain);
                        this.$router.push('/trading');
                    }
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
            isAccessAllowed() {
                axios.get('check/access').then(response => {
                    this.accessAllowed = response.data.status;
                    this.block = this.accessAllowed ? 'none' : 'block';
                });
            },
            hasError(key) {
                return !this.errors.hasOwnProperty(key) ? null : false;
            },
            trimPlusSign() {
                this.form.phone = this.form.phone.replace('+', '');
            },
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
        },
        computed: {
            platformSettings() {
                return window.baseSettings.platform;
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