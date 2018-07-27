let Api = {
    apiUrl: spotSettings.ajaxCallBack,
    customer: null,
    init: function () {
        let loggedIn = SO.model.Customer.isLoggedIn();
        if (loggedIn === true) {
            Api.customer = SO.model.Customer.currentCustomer;
            Api.getCustomerDetails();
        }
        Api.switchMenuButtons(loggedIn);
        $('#loginForm').on('submit', function (e) {
            e.preventDefault();
            Api.loginSubmit(this);
        });
        $('#logoutButton').on('click', function (e) {
            e.preventDefault();
            SO.model.Customer.logout({
                onFail: function () {
                    location.href = '/';
                },
                onSuccess: function () {
                    location.href = '/'
                }
            });
        });
    },
    buildPersonalHeader: function (user) {
        let loggedIn = $('.loggedIn');
        loggedIn.find('.userName').html(`<strong>${user.FirstName} ${user.LastName} (id: ${user.id})</strong>`);
        if (user.verification !== 'Full') {
            $('.userVerification').html('<img width="12" height="12" src="/vendor/spot/images/attention.png" style="vertical-align: baseline;"> Not Verified');
        }
        if ((user.VIPGroup && user.VIPGroup === 'VIP')) {
            $('.userVip').html('<img width="24" height="12" src="/vendor/spot/images/vip_badge.png" style="vertical-align: baseline;">');
        }
        let currency = '$';
        switch (user.currency) {
            case 'USD':
                currency = '$';
                break;
            case 'EUR':
                currency = '€';
                break;
            case 'GBP':
                currency = '£';
                break;
        }
        let balance = parseFloat(user.accountBalance).toFixed(2);
        loggedIn.find('.userBalance').html(`<span class="text-success">${currency}${balance}</span>`);
    },
    switchMenuButtons: function (logged) {
        if (logged) {
            $('.notLoggedIn, .open-account').addClass('d-none');
            $('.loggedIn, .my-account').removeClass('d-none');
        } else {
            $('.loggedIn, .my-account').addClass('d-none');
            $('.notLoggedIn, .open-account').removeClass('d-none');
        }
    },
    getCustomerDetails: function () {
        $.ajax({
            url: '//' + this.apiUrl + '/RPCWP/getCustomerDetails',
            type: "POST",
            dataType: 'json',
            attachSession: true,
            success: function (result) {
                if (result === 'notLoggedIn') {
                    document.cookie = 'WPcustomerId=0; expires=Fri, 27 Jul 2001 02:47:11 UTC; path=/';
                    return false;
                } else {
                    document.cookie = "WPcustomerId=" + result.id + ";path=/";
                    Api.buildPersonalHeader(result);
                }
            }
        });
    },
    loginSubmit: function (form, redirect) {
        SO.model.Customer.login({
            email: $(form).find('input[type="email"]').val(),
            password: $(form).find('input[type="password"]').val(),
            onSuccess: function (data) {
                if (typeof(redirect) === 'undefined') {
                    location.reload();
                } else {
                    window.location = redirect;
                }
            },
            onError: function (data) {
                console.log('error');
            },
            onFail: function (err) {
                console.log('fail');
            }
        });
    }
};

$(document).on('spotoptionPlugin.ready', Api.init);
