<template>
    <div>
        <div id="mobile-menu-wrapper" class="mobile-menu-wrapper hidden-sm-down">
            <button class="hamburger hamburger--spin" id="mobile-nav-button" type="button">
        <span class="hamburger-box">
            <span class="hamburger-inner"></span>
        </span>
            </button>
            <div class="menu-title">
                <router-link to="/">
                    <img class="mobile-logo" src="../../../img/pic/cfsum.png">
                </router-link>
            </div>
            <div class="mobile-nav">
                <custom-menu menu-name="top-menu" @loaded="mobileLoaded"></custom-menu>
            </div>
        </div>
    <header class="section header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="general my-3 my-md-0">
                        <div class="logo d-lg-block d-none">
                            <router-link to="/">
                                <img src="../../../img/pic/cfsum.png" alt="logo">
                            </router-link>
                        </div>
                        <div class="profile">
                            <login-form></login-form>
                        </div>
                    </div>
                    <div class="ui navigation d-lg-block d-none">
                        <custom-menu menu-name="top-menu"></custom-menu>
                    </div>
                </div>
            </div>
        </div>
    </header>
    </div>
</template>

<script>
    import CustomMenu from "../CustomMenu";
    import LoginForm from "../common/LoginForm";
    export default {
        methods: {
            mobileLoaded() {
                jQuery(document).ready(function () {
                    let mobileNavButton = $('#mobile-nav-button'),
                        mobileNav = $('.mobile-nav');
                    mobileNav.hide(0);
                    mobileNav.find('.menu-item-has-children > a').click((function (e) {
                        e.preventDefault();
                        $(this).parent().toggleClass('expanded');
                    }));
                    mobileNavButton.click(function (e) {
                        e.preventDefault();
                        $(this).stop().toggleClass('is-active');
                        if ($(this).hasClass('is-active')) {
                            mobileNav.stop().slideDown();
                        } else {
                            mobileNav.stop().slideUp();
                        }
                    });
                });
            }
        },
        components: { LoginForm, CustomMenu },
    }
</script>