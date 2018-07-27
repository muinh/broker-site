<?php
namespace App\Platforms\Helpers;

use RuntimeException;

class Payment
{
    public $formUrl = 'https://sandbox.solidpayments.com/paynet/api/v2/sale-form/group/';

    public function sendRequest($url, array $requestFields)
    {
        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_HEADER => 0,
            CURLOPT_USERAGENT => 'SolidPayments-Client/1.0',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1
        ]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestFields));
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_code = curl_errno($curl);
            $error_message = 'Error occurred: ' . curl_error($curl);
        } elseif (curl_getinfo($curl, CURLINFO_HTTP_CODE) != 200) {
            $error_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $error_message = "Error occurred. HTTP code: '{$error_code}'";
        }
        curl_close($curl);
        if (!empty($error_message)) {
            throw new RuntimeException($error_message, $error_code);
        }
        if (empty($response)) {
            throw new RuntimeException('Host response is empty');
        }
        $responseFields = [];
        parse_str($response, $responseFields);
        return $responseFields;
    }

    /**
     * @param $s
     * @param $merchantControl
     * @return string
     */
    public function signString($s, $merchantControl)
    {
        return sha1($s . $merchantControl);
    }

    /**
     * Signs payment (sale/auth/transfer) request
     *
     * @param    array $requestFields request array
     * @return string
     */
    public function signPaymentRequest($requestFields)
    {
        $base = '';
        $base .= config('payment.endPointGroupId');
        $base .= @$requestFields['client_orderid'];
        $base .= @$requestFields['amount'] * 100;
        $base .= @$requestFields['email'];

        return $this->signString($base, config('payment.merchantKey'));
    }

    /**
     * Signs status request
     *
     * @param    array $requestFields request array
     * @param    string $login merchant login
     * @param    string $merchantControl merchant control key
     * @return string
     */
    public function signStatusRequest($requestFields, $login, $merchantControl)
    {
        $base = '';
        $base .= $login;
        $base .= $requestFields['client_orderid'];
        $base .= $requestFields['orderid'];

        return $this->signString($base, $merchantControl);
    }

    public function getForm($requestFields)
    {
        $serverFields = [
            'ipaddress' => request()->ip(),
            'order_desc' => 'Deposit',
            'control' => $this->signPaymentRequest($requestFields),
            'redirect_url' => secure_url('depositReceived'),
//            'server_callback_url' => 'https://cfsum.com/api/',
        ];
        $requestFields = array_merge($requestFields, $serverFields);

        $response = $this->sendRequest($this->formUrl . config('payment.endPointGroupId'), $requestFields);
        return array_get($response, 'redirect-url');
    }
}