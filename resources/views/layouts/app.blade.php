<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <script>
        window.baseSettings = {
            appName: '{{config('app.name')}}',
            platform: {
                baseUrl: '{{ config('bx8.baseUrl') }}',
                brokerName: '{{ config('bx8.brokerName') }}',
                tradingUrl: '{{ config('bx8.tradingUrl') }}',
                cookieDomain: '{{ config('bx8.cookieDomain') }}'
            }
        }
    </script>
</head>
<body>
    <div id="app"></div>
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type='text/javascript'>
        (function(){ var widget_id = 'wOWoMLsEQF';var d=document;var w=window;function l(){
            var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
    </script>
    <script>
        function setCookie(name, value, days, path, domain, secure) {
            let date = new Date();
            days = days || 1;
            date.setTime(+ date + (days * 86400000));
            document.cookie = name + "=" + encodeURI(value) + "; expires=" + date.toGMTString() +
                ((path) ? "; path=" + path : "") +
                ((domain) ? "; domain=" + domain : "") +
                ((secure) ? "; secure" : "");
        }
        function delCookie(name, domain) {
            document.cookie = name + "=;" + ((domain) ? "; domain=" + domain : "") + "expires=Thu, 01 Jan 1970 00:00:01 GMT";
        }
        window.addEventListener('message', (e) => {
            let data = e.data;
            if (data.isbx8 === true) {
                switch (data.action) {
                    case 'signin':
                        setCookie('BX8Trader-Auth', data.token, 7, '/', '{{ config('bx8.cookieDomain') }}');
                        break;
                    case 'signout':
                        delCookie('BX8Trader-Auth', '{{ config('bx8.cookieDomain') }}');
                        break;
                }
            }
        }, false);
    </script>
</body>
</html>