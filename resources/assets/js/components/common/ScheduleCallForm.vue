<template>
    <form class="cfsum-form col-12" name="cfsum-form" ref="cfsum-form" novalidate="novalidate" @submit.prevent="submitScheduleCall">
        <div class="container">
            <div class="row">
                <div class="col-md-3 ui form-field mt-2 style-default">
                    <span class="cfdsum-form-control-wrap firstName">
                        <input type="text" name="firstName" v-model="form.firstName" min="2" size="40" class="cfdsum-form-control cfdsum-text cfdsum-validates-as-required form-control schedule-input" id="firstName" aria-required="true" aria-invalid="false" placeholder="First Name" required>
                    </span>
                    <p class="cfsum-danger small" v-text="errorMessages.firstName">{{errorMessages.firstName}}</p>
                </div>
                <div class="col-md-3 mt-2 ui form-field style-default">
                    <span class="cfdsum-form-control-wrap lastName">
                        <input type="text" name="lastName" v-model="form.lastName" min="2" size="40" class="cfdsum-form-control cfdsum-text cfdsum-validates-as-required form-control schedule-input" id="lastName" aria-required="true" aria-invalid="false" placeholder="Last Name">
                    </span>
                    <p class="cfsum-danger small" v-text="errorMessages.lastName">{{errorMessages.lastName}}</p>
                </div>
                <div class="col-md-2 mt-2 ui form-field style-default">
                    <span class="cfdsum-form-control-wrap phone">
                        <input type="tel" name="phone" v-model="form.phone" size="40" class="cfdsum-form-control cfdsum-text cfdsum-tel cfdsum-validates-as-required cfdsum-validates-as-tel form-control schedule-input" id="phone" aria-required="true" aria-invalid="false" placeholder="Phone" required>
                    </span>
                    <p class="cfsum-danger small" v-text="errorMessages.phone">{{errorMessages.phone}}</p>
                </div>
                <div class="col-md-2 mt-2 ui form-field style-default">
                    <span class="cfdsum-form-control-wrap country">
                        <b-form-select class="schedule-select" :options="countries" v-model="form.country"></b-form-select>
                    </span>
                    <p class="cfsum-danger small" v-text="errorMessages.country">{{errorMessages.country}}</p>
                </div>
                <div class="col-md-2 mt-2 ui form-field style-default">
                    <span class="cfdsum-form-control-wrap age">
                        <input type="number" name="age" v-model="form.age" class="cfdsum-form-control cfdsum-number cfdsum-validates-as-number form-control schedule-input" id="age" min="18" aria-invalid="false" placeholder="Age" required>
                    </span>
                    <p class="cfsum-danger small" v-text="errorMessages.age">{{errorMessages.age}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center mt-3">
                    <input type="submit" value="Schedule a Call" class="ui btn btn-bottom btn-red" :disabled="disabled">
                </div>
            </div>
            <div class="row justify-content-center padding-success text-center">
                <div v-if="message" class="col-md-8 cfsum-response cfdsum-display-none pt-2 bg-success">
                    {{message}}
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    const errorMessages = {
        firstName: '',
        lastName: '',
        phone: '',
        country: '',
        age: ''
    };
    const countries = ["United Kingdom","Aruba","Afghanistan","Angola","Anguilla","Åland Islands","Albania","Andorra","United Arab Emirates","Argentina","Armenia","American Samoa","Antarctica","French Southern Territories","Antigua and Barbuda","Australia","Austria","Azerbaijan","Burundi","Belgium","Benin","Bonaire, Sint Eustatius and Saba","Burkina Faso","Bangladesh","Bulgaria","Bahrain","Bahamas","Bosnia and Herzegovina","Saint Barthélemy","Belarus","Belize","Bermuda","Bolivia, Plurinational State of","Brazil","Barbados","Brunei Darussalam","Bhutan","Bouvet Island","Botswana","Central African Republic","Canada","Cocos (Keeling) Islands","Switzerland","Chile","China","Côte d'Ivoire","Cameroon","Congo, the Democratic Republic of the","Congo","Cook Islands","Colombia","Comoros","Cape Verde","Costa Rica","Cuba","Curaçao","Christmas Island","Cayman Islands","Cyprus","Czech Republic","Germany","Djibouti","Dominica","Denmark","Dominican Republic","Algeria","Ecuador","Egypt","Eritrea","Western Sahara","Spain","Estonia","Ethiopia","Finland","Fiji","Falkland Islands (Malvinas)","France","Faroe Islands","Micronesia, Federated States of","Gabon","United Kingdom","Georgia","Guernsey","Ghana","Gibraltar","Guinea","Guadeloupe","Gambia","Guinea-Bissau","Equatorial Guinea","Greece","Grenada","Greenland","Guatemala","French Guiana","Guam","Guyana","Hong Kong","Heard Island and McDonald Islands","Honduras","Croatia","Haiti","Hungary","Indonesia","Isle of Man","India","British Indian Ocean Territory","Ireland","Iran, Islamic Republic of","Iraq","Iceland","Israel","Italy","Jamaica","Jersey","Jordan","Japan","Kazakhstan","Kenya","Kyrgyzstan","Cambodia","Kiribati","Saint Kitts and Nevis","Korea, Republic of","Kuwait","Lao People's Democratic Republic","Lebanon","Liberia","Libya","Saint Lucia","Liechtenstein","Sri Lanka","Lesotho","Lithuania","Luxembourg","Latvia","Macao","Saint Martin (French part)","Morocco","Monaco","Moldova, Republic of","Madagascar","Maldives","Mexico","Marshall Islands","Macedonia, the former Yugoslav Republic of","Mali","Malta","Myanmar","Montenegro","Mongolia","Northern Mariana Islands","Mozambique","Mauritania","Montserrat","Martinique","Mauritius","Malawi","Malaysia","Mayotte","Namibia","New Caledonia","Niger","Norfolk Island","Nigeria","Nicaragua","Niue","Netherlands","Norway","Nepal","Nauru","New Zealand","Oman","Pakistan","Panama","Pitcairn","Peru","Philippines","Palau","Papua New Guinea","Poland","Puerto Rico","Korea, Democratic People's Republic of","Portugal","Paraguay","Palestine, State of","French Polynesia","Qatar","Réunion","Romania","Russian Federation","Rwanda","Saudi Arabia","Sudan","Senegal","Singapore","South Georgia and the South Sandwich Islands","Saint Helena, Ascension and Tristan da Cunha","Svalbard and Jan Mayen","Solomon Islands","Sierra Leone","El Salvador","San Marino","Somalia","Saint Pierre and Miquelon","Serbia","South Sudan","Sao Tome and Principe","Suriname","Slovakia","Slovenia","Sweden","Swaziland","Sint Maarten (Dutch part)","Seychelles","Syrian Arab Republic","Turks and Caicos Islands","Chad","Togo","Thailand","Tajikistan","Tokelau","Turkmenistan","Timor-Leste","Tonga","Trinidad and Tobago","Tunisia","Turkey","Tuvalu","Taiwan, Province of China","Tanzania, United Republic of","Uganda","Ukraine","United States Minor Outlying Islands","Uruguay","United States","Uzbekistan","Holy See (Vatican City State)","Saint Vincent and the Grenadines","Venezuela, Bolivarian Republic of","Virgin Islands, British","Virgin Islands, U.S.","Viet Nam","Vanuatu","Wallis and Futuna","Samoa","Yemen","South Africa","Zambia","Zimbabwe"];
    export default {
        name: "schedule-call-form",
        data() {
            return {
                errorMessages,
                countries,
                message: '',
                disabled: false,
                form: {
                    firstName: null,
                    lastName: null,
                    phone: null,
                    country: 'United Kingdom',
                    age: null,
                }
            }
        },
        methods: {
            submitScheduleCall() {
                this.disabled = true;
                this.message = '';
                this.errorMessages = errorMessages;
                axios.post('/api/call', this.form)
                .then(response => {
                    this.message = response.data.message;
                }).catch(error => {
                    this.disabled = !this.disabled;
                    this.errorMessages = Object.assign({}, _.mapValues(error.response.data.errors, error => {return _.head(error)}));
                });
            }
        }
    }
</script>

<style scoped>
    .schedule-select {
        height: 43px !important;
    }
    .schedule-input:disabled.schedule-input:focus {
        opacity: 0.6;
    }
    .cfsum-response {
        height: 40px;
        color: #fff;
        border-radius: 1%;
        opacity: 0.8;
    }
    .cfdsum-submit {
        outline: none;
    }
    .cfdsum-submit:disabled {
        background-color: #4e4e4e !important;
        cursor: not-allowed;
    }
    .cfsum-danger {
        color: #ffffff;
    }
    .padding-success {
        padding-top: 2rem;
    }
</style>