<?php
namespace App\Platforms\Bx8;

use App\Models\Setting;
use App\Platforms\Bx8\Transformers\CustomerTransformer;
use App\Platforms\Exceptions\EmailAlreadyExistsException;
use App\Platforms\Exceptions\UserNotFoundException;

class Bx8Integrator
{
    private $api;
    private $crmApi;
    private $tradingApi;

    public function __construct()
    {
        $this->api = new Api();
        $this->crmApi = new CrmApi();
        $this->tradingApi = new Api(true);
    }

    /**
     * @return array
     */
    public function getCountries()
    {
        $response = $this->api->sendRequest('countries');
        try {
            $this->checkResponse($response);
        } catch (\Exception $e) {
            return [];
        }
        return array_get($response, 'countries');
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function getCustomerById($id)
    {
        $response = $this->api->sendRequest('account', ['id' => $id]);
        $this->checkResponse($response);
        return (new CustomerTransformer)->get($response);
    }

    public function getCustomerProfile($id)
    {
        $response = $this->crmApi->makeRequest('get/customer', compact('id'));
        return collect(array_get($response, 'records.0'))
            ->only(['City', 'PostalCode', 'Street', 'state', 'VerificationStatus'])->toArray();
    }

    /**
     * @param $email
     * @return array
     * @throws \Exception
     */
    public function getCustomerByEmail($email)
    {
        $response = $this->api->sendRequest('account', ['email' => $email]);
        $this->checkResponse($response);
        return (new CustomerTransformer)->get($response);
    }

    /**
     * @param $params
     * @return bool
     * @throws \Exception
     */
    public function setPassword($params)
    {
        $response = $this->api->sendRequest('account/setpassword', $params);
        $this->checkResponse($response);
        return true;
    }

    /**
     * @param $userId
     * @return mixed
     * @throws \Exception
     */
    public function loginById($userId)
    {
        $response = $this->api->sendRequest('auth/GetTradingPlatformToken', ['userId' => $userId]);
        $this->checkResponse($response);
        $token = array_get($response, 'token');
        return $token;
    }

    /**
     * @param $traderToken
     * @return array
     * @throws \Exception
     */
    public function getTraderByToken($traderToken)
    {
        $response = $this->validateToken($traderToken);
        $userId = array_get($response, 'userId');
        $trader = $this->getCustomerById($userId);
        $trader = array_merge($trader, $this->getCustomerProfile($userId));
        return $trader;
    }

    /**
     * @param $traderToken
     * @return array
     * @throws \Exception
     */
    public function validateToken($traderToken)
    {
        $response = $this->api->sendRequest('account/validatetoken', ['token' => $traderToken]);
        $this->checkResponse($response);
        return $response;
    }

    /**
     * @param $traderToken
     * @return mixed
     * @throws \Exception
     */
    public function forceLogout($traderToken)
    {
        $customer = $this->getTraderByToken($traderToken);
        $AccountId = array_get($customer, 'id');
        if ($AccountId) {
            $this->api->sendRequest('account/ForceLogout', compact('AccountId'), 'post');
            return ['message' => 'Successfully logged out'];
        }
        throw new \Exception('LogOut failed');
    }

    /**
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function register($data)
    {
        $params = [
            'FirstName' => array_get($data, 'firstName'),
            'LastName' => array_get($data, 'lastName'),
            'email' => array_get($data, 'email'),
            'Password' => array_get($data, 'password'),
            'PhoneNumber' => array_get($data, 'phone'),
            'CountryISO' => array_get($data, 'country'),
            'Currency' => array_get($data, 'currency'),
            'Language' => array_get($data, 'language', 'English')
        ];
        $params['PhoneNumber'] = $this->trimPlusSign($params);
        $response = $this->api->sendRequest('account', $params, 'post');
        $this->checkResponse($response);
        $accountId = array_get($response, 'accountId');
        if ($accountId) {
            return ['token' => $this->loginById($accountId)];
        }
        return ['message' => array_get($response, 'message'), 'token' => false];
    }

    /**
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function update($data)
    {
        $id = array_get($data, 'AccountId');
        $params = [
            'AccountId' => $id,
            'FirstName' => array_get($data, 'FirstName'),
            'LastName' => array_get($data, 'LastName'),
            'PhoneNumber' => array_get($data, 'phone'),
            'CountryISO' => array_get($data, 'country')
        ];
        $crmParams = [
            'street'        => array_get($data, 'Street'),
            'state'         => array_get($data, 'state'),
            'postCode'      => array_get($data, 'PostalCode'),
            'city'          => array_get($data, 'City')
        ];
        $params['PhoneNumber'] = $this->trimPlusSign($params);
        $response = $this->api->sendRequest('account/update', $params, 'post');
        $crmResponse = $this->crmApi->makeRequest('update/customer/' . $id, $crmParams);
        $this->checkResponse($response);

        return ['message' => array_get($response, 'message')];
    }

    public function registerLead($lead)
    {
        unset($lead->id);
        $lead->Language = 'English';
        $lead->AffiliateId = 314;
        $lead->PhoneNumber = $this->trimPlusSign($lead);
        try {
            $response = $this->api->sendRequest('lead', $lead, 'post');
        } catch (\Exception $e) {
            \Log::info($e->getMessage(), json_encode($lead));
        }
        return array_get($response, 'leadId') ? 1 : 0;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function trimPlusSign($data)
    {
        $phone = is_array($data) ? $data['PhoneNumber'] : $data->PhoneNumber;
        return str_replace('+', '', $phone);
    }

    /**
     * @param $lastId
     */
    public function setLastLead($lastId)
    {
        Setting::query()->updateOrInsert(
            ['key' => 'csv.last_lead'],
            ['display_name' => 'Replica Last Lead',
            'type' => 'text',
            'group' => 'Csv',
            'value' => $lastId]
        );
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getLastDeposits()
    {
        return [
            [
                "id" => "8fb63147-93a8-4597-9124-a90b00e258e4",
                "source" => "External",
                "accountId" => "b01df34b-c7b5-4eab-b1fe-a8fe00d61bd2",
                "cancelledTransactionId" => null,
                "date" => "2018-06-26T13:44:06.303Z",
                "amount" => 100000.0,
                "currency" => "USD",
                "conversionRate" => 1.0,
                "commissions" => "",
                "type" => "Deposit",
                "status" => "Confirmed",
                "rejectReason" => null
            ]
        ];
        $params = [
            'from' => '2018-06-25',
            'to' => '2018-06-27'
        ];
        $response = $this->api->sendRequest('deposits', $params);
        $this->checkResponse($response);
        return $response;
    }

    public function accountLogin($username, $password)
    {
        $response = $this->api->sendRequest('auth/login', [
            'username' => $username,
            'password' => $password,
            'brokername' => config('bx8.brokerName')
        ], 'post');
        $token = array_get($response, 'token');
        return $token;
    }

    public function getToken()
    {
        $response = $this->api->sendRequest('auth/login', [
            'username' => config('bx8.adminUser'),
            'password' => config('bx8.adminPassword'),
            'brokername' => config('bx8.brokerName')
        ], 'post');
        $token = array_get($response, 'token');
        if ($token) {
            Setting::query()->updateOrInsert(['key' => 'api.token'], [
                'display_name' => 'BX8 Api Token',
                'type' => 'text',
                'group' => 'Api',
                'value' => $token
            ]);
        } else {
            \Log::error("BX8 error: \n\n" . json_encode($response, JSON_PRETTY_PRINT));
        }
        return $token;
    }

    /**
     * @param $response
     * @throws \Exception
     */
    public function checkResponse($response)
    {
        $message = array_get($response, 'message');
        if (substr($message, 0, 4) == 'User' && substr($message, -9) == 'not found') {
            throw  new UserNotFoundException();
        }
        if ($message == 'Failed to create user - Username already exist') {
            throw new EmailAlreadyExistsException();
        }
        if ($message == 'Cannot get the price for the option.') {
            throw new \Exception('Cannot get the price for the option.');
        }
        if (array_get($response, 'positionId') == '00000000-0000-0000-0000-000000000000') {
            throw new \Exception('Position GUID error');
        }
    }
}