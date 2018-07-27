<?php
if (!function_exists('link_active')) {
    function link_active($path)
    {
        return str_is($path, '/' . ltrim(request()->path(), '/')) ?? 'active';
    }
}
if (!function_exists('get_country_code')) {
    function get_country_code()
    {
        $client = new GuzzleHttp\Client();
        $response = $client->get('http://ip-api.com/json/' . request()->ip());
        return array_get(json_decode($response->getBody()->getContents(), true), 'countryCode', '');
    }
}
if (!function_exists('get_allowed_countries')) {
    function get_allowed_countries()
    {
        return \App\Models\AllowedCountry::all()->map(function ($item) {
            return $item->code;
        });
    }
}
if (!function_exists('get_allowed_ips')) {
    function get_allowed_ips()
    {
        return \App\Models\AllowedIp::all()->map(function ($item) {
            return $item->ip;
        });
    }
}
if (!function_exists('is_allowed_country')) {
    function is_allowed_country()
    {
        return get_allowed_countries()->contains(get_country_code());
    }
}
if (!function_exists('is_allowed_ip')) {
    function is_allowed_ip()
    {
        return get_allowed_ips()->contains(request()->ip());
    }
}
