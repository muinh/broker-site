<html>
<head>=
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css" integrity="sha384-v2Tw72dyUXeU3y4aM2Y0tBJQkGfplr39mxZqlTBDUZAb9BGoC40+rdFCG0m10lXk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css" integrity="sha384-q3jl8XQu1OpdLgGFvNRnPdj5VIlCvgsDQTQB6owSOHWlAurxul7f+JpUOVdAiJ5P" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <style>
        .centered {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .colored {
            color: #7cbbb7;
        }
    </style>
</head>
<body class="section header">
    <div class="centered colored">
        <i class="fas fa-cog fa-spin fa-10x"></i>
    </div>
<script>
    function ready(fn) {
        if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading"){
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }
    function post(url, data, callback) {
        let request = new XMLHttpRequest();
        request.open('POST', url, true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.onload = callback;
        request.send(data);
    }
    ready(function() {
        let query = location.search.substr(1);
        query += '&_token=' + '{{ csrf_token() }}';
        post('/autoLogin', query, (response) => {
            let responseJson = JSON.parse(response.target.responseText);
            if (responseJson.hasOwnProperty('token') && responseJson.token) {
                document.cookie = `BX8Trader-Auth=${responseJson.token}; path=/;domain={{ config('bx8.cookieDomain') }}`;
            }
            window.location.href = '/trading';
        });
    });
</script>
</body>
</html>