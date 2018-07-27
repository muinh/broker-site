<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    function createCookie(name, value, expires, path, domain) {
        let cookie = name + "=" + encodeURIComponent(value) + ";";
        if (expires) {
            if (expires instanceof Date) {
                if (isNaN(expires.getTime()))
                    expires = new Date();
            }
            else
                expires = new Date(new Date().getTime() + parseInt(expires) * 1000 * 60 * 60 * 24);
            cookie += "expires=" + expires.toGMTString() + ";";
        }
        if (path)
            cookie += "path=" + path + ";";
        if (domain)
            cookie += "domain=" + domain + ";";
        document.cookie = cookie;
    }
</script>
<script>
    jQuery(document).ready(function () {
        let mobileNavButton = $('#mobile-nav-button'),
            mobileNav = $('.mobile-nav');
        mobileNav.hide(0);
        $('header .navigation ul:first-child').clone().appendTo(mobileNav);
        mobileNav.find('.menu-item-has-children > a').click((function (e) {
            e.preventDefault();
            $(this).parent().toggleClass('expanded');
        }));
        mobileNavButton.click(function (e) {
            e.preventDefault();
            $(this).stop().toggleClass('is-active');
            if ($this.hasClass('is-active')) {
                mobileNav.stop().slideDown();
            } else {
                mobileNav.stop().slideUp();
            }
        });

        let $country = $('#country');
        let $phone = $('#phone');
        $.ajax({
            url: '/api/geo',
            success: function (result) {
                if (result.hasOwnProperty('countries')) {
                    $.each(result.countries, function (i, element) {
                        $('<option/>').appendTo($country).val(element.iso).text(element.name);
                    });
                }
                if (result.hasOwnProperty('iso')) {
                    $country.val(result.iso);
                }
                if (result.hasOwnProperty('prefix')) {
                    $phone.val(result.prefix);
                }
            }
        });

        function setErrors(form, result) {
            result = result || {};
            if (result.hasOwnProperty('errors')) {
                let errors = result.errors;
                for (let error in errors) {
                    if (errors.hasOwnProperty(error)) {
                        form.find(`[name="${error}"]`).addClass('is-invalid').parent().append(`<div class="invalid-feedback">${errors[error]}</div>`);
                    }
                }
            }
            if (result.hasOwnProperty('message')) {
                form.find('#errors').html(result.message).show(0);
            }
        }

        function clearErrors(form) {
            form.find('#errors').hide(0);
            form.find('input,select').removeClass('is-invalid').parent().find('div.invalid-feedback').remove();
        }

        $('.register-form').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let fields = form.serialize();
            let submit = form.find('button[type="submit"]');
            submit.attr('disabled', true);
            clearErrors(form);
            $.ajax({
                type: 'POST',
                url: '/api/register',
                data: fields,
                success: (result) => {
                    if (result.token !== false) {
                        createCookie('BX8Trader-Auth', result.token, 1, '/', '{{ config('bx8.cookieDomain') }}');
                        window.location.href = '/trading';
                    }
                },
                error: (e) => {
                    setErrors(form, e.responseJSON);
                    submit.attr('disabled', false);
                }
            });
        });
        window.addEventListener('message', (e) => {
            let data = e.data;
            if (data.isbx8 === true) {
                switch (data.action) {
                    case 'signout':
                        document.cookie = 'BX8Trader-Auth=; path=/;domain={{ config('bx8.cookieDomain') }};expires=Thu, 01 Jan 1970 00:00:01 GMT';
                        break;
                }
            }
        }, false);

    });
</script>