<template>
    <div class="body">
        <div class="gdpr-notice text-white" id="gdpr-notice">
            <div class="gdpr-notice-text d-flex justify-content-center align-items-center">
                <span>
                    We use a range of cookies to give you the best possible browsing experience. By continuing to use this <br>website, you agree to our use of cookies. You can view our <router-link to="/cookie-policy">Cookie Policy</router-link>.
                </span>
                <div class="pl-5">
                    <a href="#" class="gdpr-notice-close ui btn btn-sm btn-bottom btn-red" id="gdpr-notice-close" @click.prevent="checkAgreementOnEvent">Agree</a>
                </div>
            </div>
        </div>
        <keep-alive>
            <component v-if="page" :is="page.type" :page="page"></component>
        </keep-alive>
    </div>
</template>

<script>
    import Page from './Page';
    import Tabs from './Tabs';
    import HomePage from './HomePage';
    import EmptyPage from './EmptyPage';

    export default {
        components: {Page, Tabs, HomePage, EmptyPage},
        data() {
            return {
                page: null,
                scripts: [],
                styles: []
            }
        },
        mounted() {
            this.checkAgreement();
            this.getPage(this.$route.params.slug);
        },
        watch:{
            $route (to){
                _.each(this.scripts.concat(this.styles), (id) => {
                    $(`#${id}`).remove();
                });
                this.getPage(to.params.slug);
            }
        },
        methods: {
            getPage(slug) {
                slug = slug || 'index';
                axios.get(`/api/page/${slug}`)
                    .then(response => {
                        this.page = response.data;
                        document.title = window.baseSettings.appName ? this.page.title + ' - ' + window.baseSettings.appName : this.page.title;
                        this.plugStyles(response.data);
                        this.plugScripts(response.data);
                    })
                    .catch((err) => {
                        console.log(err);
                        this.$router.push('/');
                    });
            },
            plugStyles(page) {
                _.each(page.styles, item => {
                    let guid = this.generateGuid();
                    let style = document.createElement('style');
                    style.innerHTML = item.style;
                    style.type = 'text/css';
                    style.id = guid;
                    this.styles.push(guid);
                    document.head.appendChild(style);
                });
            },
            plugScripts(page) {
                _.each(page.scripts, item => {
                    let guid = this.generateGuid();
                    let script = document.createElement('script');
                    script.id = guid;
                    this.scripts.push(guid);
                    /*check is external script or internal*/
                    if (this.isValidURL(item.script)) {
                        script.src = item.script;
                        script.defer = true;
                    } else {
                        script.text = item.script;
                    }
                    /*check is plugged to head or body*/
                    if (item.position_head) {
                        document.head.appendChild(script);
                    } else {
                        document.body.appendChild(script);
                    }
                });
            },
            isValidURL(str) {
                let a  = document.createElement('a');
                a.href = str;
                return (a.host && a.host !== window.location.host);
            },
            generateGuid() {
                return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                    return v.toString(16);
                });
            },
            hasGdprAgreed(arr) {
                for (let cookie of arr) {
                    if (cookie.replace(/ /g,'').includes('agreedGDPR')) {
                        return true;
                    }
                }
            },
            checkAgreement() {
                let arr = decodeURIComponent(document.cookie).split(';');
                if (this.hasGdprAgreed(arr)) {
                    let container = document.getElementById('gdpr-notice');
                    container.style.display = 'none';
                }
            },
            checkAgreementOnEvent() {
                let arr = decodeURIComponent(document.cookie).split(';');
                !this.hasGdprAgreed(arr) ? document.cookie = 'agreedGDPR=true' : '';
                document.getElementById('gdpr-notice').style.display = 'none';
            }
        }
    }
</script>