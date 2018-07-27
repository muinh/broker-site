<?php
namespace App\Http\Controllers\bx8;

use App\Mail\RegisterCustomer;
use App\Models\Country;
use App\Platforms\Helpers\Payment;
use App\Validators\CustomCaptchaApi;
use Carbon\Carbon;
use App\Models\ResetToken;
use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use App\Platforms\Bx8\Bx8Integrator;

class PlatformController extends BaseController
{
    public function trader(Request $request)
    {
        /** @var Bx8Integrator $client */
        $client = app()->make('bx8');
        $traderToken = $request->cookie('BX8Trader-Auth');
        if (!isset($traderToken)) {
            return response(['message' => 'Unauthorized'], 401);
        }
        try {
            $trader = $client->getTraderByToken($traderToken);
            return $trader;
        } catch (\Exception $exception) {
            return response(['message' => $exception->getMessage()], 422);
        }
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'firstName' => 'required|min:3',
            'lastName' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'phone' => 'required|min:6',
            'country' => 'required',
            'currency' => 'required',
            'terms' => 'accepted',
            'gdpr' => 'accepted',
            'captcha' => ['required', new CustomCaptchaApi]
        ]);
        /** @var Bx8Integrator $client */
        $client = app()->make('bx8');
        try {
            $registerResponse = $client->register($request->all());
            \Mail::to($request->get('email'))->sendNow(new RegisterCustomer($request->only(['firstName', 'lastName', 'email'])));
            return $registerResponse;
        } catch (\Exception $exception) {
            return response(['message' => $exception->getMessage()], 422);
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'FirstName' => 'required|min:3',
            'LastName' => 'required|min:3',
            'phone' => 'required|min:6',
            'City'  => 'max:40',
            'PostalCode' => 'max:20',
            'Street'    => 'max:40',
            'state'     => 'max:100',
        ]);
        /** @var Bx8Integrator $client */
        $client = app()->make('bx8');
        $traderToken = $request->cookie('BX8Trader-Auth');
        if (!isset($traderToken)) {
            return response(['message' => 'Unauthorized'], 401);
        }
        try {
            $account = $client->validateToken($traderToken);
            $AccountId = array_get($account, 'userId');
            $updateResponse = $client->update($request->merge(compact('AccountId'))->all());
            return $updateResponse;
        } catch (\Exception $exception) {
            return response(['message' => $exception->getMessage()], 422);
        }
    }

    public function forgot(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'captcha' => ['required', new CustomCaptchaApi]
        ]);
        /** @var Bx8Integrator $client */
        $client = app()->make('bx8');
        $email = $request->get('email');
        $resetToken = bin2hex(random_bytes(10));
        try {
            $customer = $client->getCustomerByEmail($email);
            ResetToken::query()->updateOrCreate(['email' => $email], [
                'customer_id' => @$customer['id'],
                'email' => $email,
                'token' => $resetToken,
                'expiry_date' => Carbon::now()->addDay()
            ]);
            $link = secure_url('/reset-password?token=' . $resetToken);
            $subject = env('SITE_NAME') . ' Password Recovery';
            $firstName = array_get($customer, 'FirstName');
            \Mail::to($email)->sendNow(new ResetPassword(compact('link', 'subject', 'firstName')));
            return ['message' => 'Link for resetting password was sent you via email'];
        } catch (\Exception $exception) {
            return response(['message' => $exception->getMessage()], 400);
        }
    }

    public function setPassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);
        /** @var Bx8Integrator $client */
        $client = app()->make('bx8');
        /** @var ResetToken $resetToken */
        $resetToken = ResetToken::query()->where('token', '=', $request->get('token'))
            ->whereDate('expiry_date', '>', now())->first();
        if ($resetToken) {
            try {
                $params = ['AccountId' => $resetToken->customer_id, 'password' => $request->get('password')];
                if ($client->setPassword($params)) {
                    $resetToken->delete();
                    return ['message' => 'Successfully changed password'];
                }
            } catch (\Exception $e) {
                return response(['message' => $e->getMessage()], 422);
            }
        }
        return response(['message' => 'Your token is expired.'], 403);
    }

    public function forceLogOut(Request $request)
    {
        /** @var Bx8Integrator $client */
        $client = app()->make('bx8');
        $traderToken = $request->cookie('BX8Trader-Auth');
        if (!isset($traderToken)) {
            return response(['message' => 'Unauthorized'], 401);
        }
        try {
            $logout = $client->forceLogout($traderToken);
            return $logout;
        } catch (\Exception $exception) {
            return response(['message' => $exception->getMessage()], 401);
        }
    }

    public function countries()
    {
        /** @var Bx8Integrator $client */
        $client = app()->make('bx8');
        try {
            $iso = get_country_code();
            $phonePrefix = array_get(config("geoip.country_codes"), $iso, '');
            $countries = array_map(function ($item) {
                return [
                    'iso' => array_get($item, 'iso'),
                    'name' => ucwords(strtolower(array_get($item, 'name')))
                ];
            }, (array)$client->getCountries());
            return [
                'countries' => $countries,
                'iso' => $iso,
                'prefix' => $phonePrefix
            ];
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }

    public function getCountries()
    {
        return Country::query()->with('states')->get()->toArray();
    }

    public function getPaymentRedirect(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required|',
            'country' => 'required|max:2',
            'state' => 'required',
            'city' => 'required',
            'address1' => 'required',
            'zip_code' => 'required',
            'currency' => 'required|max:3',
            'amount' => 'required',
            'client_orderid' => 'required'
        ],[
            'address1.required' => 'The address field is required.'
        ]);
        $paymentClient = new Payment();
        $form = $paymentClient->getForm($request->all());

        return compact('form');
    }
}