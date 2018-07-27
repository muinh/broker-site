<?php

namespace App\Helpers;

class Spot
{
    public static function generateSpotSettings($url = null)
    {
        $settings = [
            'dir' => 'LTR',
            'lang' => 'en',
            'theme' => 'default',
            'layout' => 'default',
            'ajaxCallBack' => setting('site.ajaxCallBack'),
            'tradingLogo' => '/storage/' . setting('site.logo'),
            'cookieOptions' => [
                'domain' => setting('site.cookieDomain'),
                'path' => '/'
            ],
            'packages' => [
                'Clock' => [
                    'settings' => [
                        'selector' => '#systemClock'
                    ]
                ],
                'SpotComm' => [
                    'settings' => [
                        'selector' => 'body:first',
                        'notificationsSelector' => '#spotComm_notifications_container'
                    ]
                ]
            ],
            'googleFonts' => [
                'families' => ['Roboto+Condensed:400,300,700:latin,latin-ext,cyrillic']
            ]
        ];
        switch ($url) {
            case 'my-account':
                $settings['packages']['MyAccount'] = [
                    'settings' => [
                        'selector' => '#so_container'
                    ]
                ];
                break;
            case 'open-account':
                $settings['packages']['OpenAccount'] = [
                    'settings' => [
                        'selector' => '#so_container',
                        'redirectUrl' => '/my-account?activeZone=deposit',
                        'redirectRegulationUrl' => '/open-account?activeZone=regulation'
                    ]
                ];
                break;
            case 'forgot-password':
                $settings['packages']['ForgotPassword'] = [
                    'settings' => [
                        'selector' => '#so_container',
                        'passwordAuthUrl' => url('/forgot-password') . '/?'
                    ]
                ];
                break;
        }
        return $settings;
    }
}