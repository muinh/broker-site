<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for when a location is not found
    | for the IP provided.
    |
    */

    'log_failures' => true,

    /*
    |--------------------------------------------------------------------------
    | Include Currency in Results
    |--------------------------------------------------------------------------
    |
    | When enabled the system will do it's best in deciding the user's currency
    | by matching their ISO code to a preset list of currencies.
    |
    */

    'include_currency' => true,

    /*
    |--------------------------------------------------------------------------
    | Default Service
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default storage driver that should be used
    | by the framework.
    |
    | Supported: "maxmind_database", "maxmind_api", "ipapi"
    |
    */

    'service' => 'ipapi',

    /*
    |--------------------------------------------------------------------------
    | Storage Specific Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many storage drivers as you wish.
    |
    */

    'services' => [

        'maxmind_database' => [
            'class' => \Torann\GeoIP\Services\MaxMindDatabase::class,
            'database_path' => storage_path('app/geoip.mmdb'),
            'update_url' => 'https://geolite.maxmind.com/download/geoip/database/GeoLite2-City.mmdb.gz',
            'locales' => ['en'],
        ],

        'maxmind_api' => [
            'class' => \Torann\GeoIP\Services\MaxMindWebService::class,
            'user_id' => env('MAXMIND_USER_ID'),
            'license_key' => env('MAXMIND_LICENSE_KEY'),
            'locales' => ['en'],
        ],

        'ipapi' => [
            'class' => \Torann\GeoIP\Services\IPApi::class,
            'secure' => true,
            'key' => env('IPAPI_KEY'),
            'continent_path' => storage_path('app/continents.json'),
            'lang' => 'en',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Default Cache Driver
    |--------------------------------------------------------------------------
    |
    | Here you may specify the type of caching that should be used
    | by the package.
    |
    | Options:
    |
    |  all  - All location are cached
    |  some - Cache only the requesting user
    |  none - Disable cached
    |
    */

    'cache' => 'all',

    /*
    |--------------------------------------------------------------------------
    | Cache Tags
    |--------------------------------------------------------------------------
    |
    | Cache tags are not supported when using the file or database cache
    | drivers in Laravel. This is done so that only locations can be cleared.
    |
    */

    'cache_tags' => ['torann-geoip-location'],

    /*
    |--------------------------------------------------------------------------
    | Cache Expiration
    |--------------------------------------------------------------------------
    |
    | Define how long cached location are valid.
    |
    */

    'cache_expires' => 30,

    /*
    |--------------------------------------------------------------------------
    | Default Location
    |--------------------------------------------------------------------------
    |
    | Return when a location is not found.
    |
    */

    'default_location' => [
        'ip' => '127.0.0.0',
        'iso_code' => 'US',
        'country' => 'United States',
        'city' => 'New Haven',
        'state' => 'CT',
        'state_name' => 'Connecticut',
        'postal_code' => '06510',
        'lat' => 41.31,
        'lon' => -72.92,
        'timezone' => 'America/New_York',
        'continent' => 'NA',
        'default' => true,
        'currency' => 'USD',
    ],
    'country_codes' => [
        'BD' => '880',
        'BE' => '32',
        'BF' => '226',
        'BG' => '359',
        'BA' => '387',
        'BB' => '+1-246',
        'WF' => '681',
        'BL' => '590',
        'BM' => '+1-441',
        'BN' => '673',
        'BO' => '591',
        'BH' => '973',
        'BI' => '257',
        'BJ' => '229',
        'BT' => '975',
        'JM' => '+1-876',
        'BV' => '',
        'BW' => '267',
        'WS' => '685',
        'BQ' => '599',
        'BR' => '55',
        'BS' => '+1-242',
        'JE' => '+44-1534',
        'BY' => '375',
        'BZ' => '501',
        'RU' => '7',
        'RW' => '250',
        'RS' => '381',
        'TL' => '670',
        'RE' => '262',
        'TM' => '993',
        'TJ' => '992',
        'RO' => '40',
        'TK' => '690',
        'GW' => '245',
        'GU' => '+1-671',
        'GT' => '502',
        'GS' => '',
        'GR' => '30',
        'GQ' => '240',
        'GP' => '590',
        'JP' => '81',
        'GY' => '592',
        'GG' => '+44-1481',
        'GF' => '594',
        'GE' => '995',
        'GD' => '+1-473',
        'GB' => '44',
        'GA' => '241',
        'SV' => '503',
        'GN' => '224',
        'GM' => '220',
        'GL' => '299',
        'GI' => '350',
        'GH' => '233',
        'OM' => '968',
        'TN' => '216',
        'JO' => '962',
        'HR' => '385',
        'HT' => '509',
        'HU' => '36',
        'HK' => '852',
        'HN' => '504',
        'HM' => '',
        'VE' => '58',
        'PR' => '+1-787',
        'PS' => '970',
        'PW' => '680',
        'PT' => '351',
        'SJ' => '47',
        'PY' => '595',
        'IQ' => '964',
        'PA' => '507',
        'PF' => '689',
        'PG' => '675',
        'PE' => '51',
        'PK' => '92',
        'PH' => '63',
        'PN' => '870',
        'PL' => '48',
        'PM' => '508',
        'ZM' => '260',
        'EH' => '212',
        'EE' => '372',
        'EG' => '20',
        'ZA' => '27',
        'EC' => '593',
        'IT' => '39',
        'VN' => '84',
        'SB' => '677',
        'ET' => '251',
        'SO' => '252',
        'ZW' => '263',
        'SA' => '966',
        'ES' => '34',
        'ER' => '291',
        'ME' => '382',
        'MD' => '373',
        'MG' => '261',
        'MF' => '590',
        'MA' => '212',
        'MC' => '377',
        'UZ' => '998',
        'MM' => '95',
        'ML' => '223',
        'MO' => '853',
        'MN' => '976',
        'MH' => '692',
        'MK' => '389',
        'MU' => '230',
        'MT' => '356',
        'MW' => '265',
        'MV' => '960',
        'MQ' => '596',
        'MP' => '+1-670',
        'MS' => '+1-664',
        'MR' => '222',
        'IM' => '+44-1624',
        'UG' => '256',
        'TZ' => '255',
        'MY' => '60',
        'MX' => '52',
        'IL' => '972',
        'FR' => '33',
        'IO' => '246',
        'SH' => '290',
        'FI' => '358',
        'FJ' => '679',
        'FK' => '500',
        'FM' => '691',
        'FO' => '298',
        'NI' => '505',
        'NL' => '31',
        'NO' => '47',
        'NA' => '264',
        'VU' => '678',
        'NC' => '687',
        'NE' => '227',
        'NF' => '672',
        'NG' => '234',
        'NZ' => '64',
        'NP' => '977',
        'NR' => '674',
        'NU' => '683',
        'CK' => '682',
        'XK' => '',
        'CI' => '225',
        'CH' => '41',
        'CO' => '57',
        'CN' => '86',
        'CM' => '237',
        'CL' => '56',
        'CC' => '61',
        'CA' => '1',
        'CG' => '242',
        'CF' => '236',
        'CD' => '243',
        'CZ' => '420',
        'CY' => '357',
        'CX' => '61',
        'CR' => '506',
        'CW' => '599',
        'CV' => '238',
        'CU' => '53',
        'SZ' => '268',
        'SY' => '963',
        'SX' => '599',
        'KG' => '996',
        'KE' => '254',
        'SS' => '211',
        'SR' => '597',
        'KI' => '686',
        'KH' => '855',
        'KN' => '+1-869',
        'KM' => '269',
        'ST' => '239',
        'SK' => '421',
        'KR' => '82',
        'SI' => '386',
        'KP' => '850',
        'KW' => '965',
        'SN' => '221',
        'SM' => '378',
        'SL' => '232',
        'SC' => '248',
        'KZ' => '7',
        'KY' => '+1-345',
        'SG' => '65',
        'SE' => '46',
        'SD' => '249',
        'DO' => '+1-809',
        'DM' => '+1-767',
        'DJ' => '253',
        'DK' => '45',
        'VG' => '+1-284',
        'DE' => '49',
        'YE' => '967',
        'DZ' => '213',
        'US' => '1',
        'UY' => '598',
        'YT' => '262',
        'UM' => '1',
        'LB' => '961',
        'LC' => '+1-758',
        'LA' => '856',
        'TV' => '688',
        'TW' => '886',
        'TT' => '+1-868',
        'TR' => '90',
        'LK' => '94',
        'LI' => '423',
        'LV' => '371',
        'TO' => '676',
        'LT' => '370',
        'LU' => '352',
        'LR' => '231',
        'LS' => '266',
        'TH' => '66',
        'TF' => '',
        'TG' => '228',
        'TD' => '235',
        'TC' => '+1-649',
        'LY' => '218',
        'VA' => '379',
        'VC' => '+1-784',
        'AE' => '971',
        'AD' => '376',
        'AG' => '+1-268',
        'AF' => '93',
        'AI' => '+1-264',
        'VI' => '+1-340',
        'IS' => '354',
        'IR' => '98',
        'AM' => '374',
        'AL' => '355',
        'AO' => '244',
        'AQ' => '',
        'AS' => '+1-684',
        'AR' => '54',
        'AU' => '61',
        'AT' => '43',
        'AW' => '297',
        'IN' => '91',
        'AX' => '+358-18',
        'AZ' => '994',
        'IE' => '353',
        'ID' => '62',
        'UA' => '380',
        'QA' => '974',
        'MZ' => '258'
    ]
];
