<template>
    <div>
        <h2 class="text-success">Dear Trader,</h2>
        <p><strong>You have yet to supply some or all of the necessary verification documents.</strong></p>
        <p>These documents are necessary for prevention of fraud, money laundering and identity theft. Please be advised that your personal information will be kept with utmost security as written in our Terms and Conditions under Privacy Policy.</p>
        <p><strong class="text-danger">NOTE: This information is mandatory under International Law. The documents below are required; any missing document will lead to a customer not being verified.</strong></p>
        <p><strong>In order to complete your verification, please send us colour copies of all the required documents:</strong></p>
        <form method="post" ref="docsForm" enctype="multipart/form-data" novalidate="novalidate" @submit.prevent="sendDocs">
            <ol class="padded">
                <li>Colour copy of a valid Passport or Government-issued ID</li>
                <div class="fileInput">
                    <input type="file" name="passport">
                </div>
                <li>Front of your Credit Card with your name and Expiry date <strong>(only last 4 digits should be visible)</strong></li>
                <div class="fileInput">
                    <input type="file" name="creditCardFront">
                </div>
                <li>Back of your Credit Card with your signature  <strong>(please cover CVV code)</strong></li>
                <div class="fileInput">
                    <input type="file" name="creditCardBack">
                </div>
                <li>Utility bill / statement with your name, address and date <strong>no more than three months old</strong></li>
                <div class="fileInput">
                    <input type="file" name="utilityBill">
                </div>
            </ol>
            <div class="text-center">
                <div class="row">
                    <div class="col-12 mt-2">
                        <span class="text-success">Click SUBMIT button to upload documents</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 my-4">
                        <button class="btn btn-bottom btn-lg">Send</button>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-4 text-center">
                <div class="col-md-8">
                    <div class="cfsum-response pt-2 bg-success"></div>
                    <div class="cfsum-response pt-2 bg-danger"></div>
                </div>
            </div>
        </form>
        <small>If however, you have already submitted these documents, please contact your Account Manager to verify.</small>
        <p>Submission of documents is a onetime process, unless you make any changes to your personal information.</p>
        <h5 class="text-success">Thank you very much for assisting us to serve you better.</h5>
    </div>
</template>

<script>
    export default {
        name: "upload-docs",
        data() {
            return {
                form: {
                    cid: null,
                    firstName: null,
                    lastName: null
                }
            }
        },
        mounted() {
            $(this.$refs.docsForm).find('.cfsum-response').hide(9);
        },
        methods: {
            sendDocs() {
                let data = new FormData();
                _.forOwn(this.$store.state.user, (v, k) => {
                    if (['id', 'FirstName', 'LastName'].indexOf(k) !== -1) {
                        data.append(k, v);
                    }
                });
                let $this = $(this.$refs.docsForm);
                $.each($this.find('input[type="file"]'), (i, v) => {
                    let file = $(v).prop('files')[0];
                    if (typeof file !== 'undefined') {
                        data.append(v.name, file);
                    }
                });
                $this.find('.error').remove();
                $this.find('.cfsum-response').hide(0);
                $.ajax({
                    url: '/api/upload-docs',
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data,
                    dataType: 'json',
                    success: (response) => {
                        if (response.hasOwnProperty('message')) {
                            $this.find('.cfsum-response.bg-success').text(response.message).show(0);
                        }
                    },
                    error: (jqXHR) => {
                        if (jqXHR.status === 413){
                            $this.find('.cfsum-response.bg-danger').text('The files are too big').show(0);
                        } else {
                            if (jqXHR.responseJSON.hasOwnProperty('errors')) {
                                $.each(jqXHR.responseJSON.errors, (index, error) => {
                                    $(`[name="${index}"]`).parent().append($('<span></span>').addClass('text-danger error').text(error[0]));
                                });
                            }
                        }
                    }
                });
            }
        }
    }
</script>

<style scoped>
    .fileInput {
        background-color: #eaeaea;
        padding: 15px;
        border-radius: 7px;
        margin: 10px 0;
        margin-left: -1em;
    }

    .fileInput input {
        display: block;
        width: 100%;
    }
    .padded {
        padding: 0 0 0 1em;
    }
</style>