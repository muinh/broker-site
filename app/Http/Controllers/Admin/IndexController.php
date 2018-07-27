<?php
namespace App\Http\Controllers\Admin;

use App\Models\Ip;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class IndexController extends BaseController {

    use AuthenticatesUsers;

    public function index()
    {
        return ;
    }

    public function postLogin(Request $request)
    {
        if (!$this->checkLoginAttempts($request)) {
            return redirect()->route('voyager.login')->withErrors('Too many requests. Try again later.');
        }
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);

        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function incrementLoginAttempts($request)
    {
        $ip = $request->ip();
        $instance = Ip::query()->where('ip', '=', $ip)->first();
        if ($instance) {
            $instance->attempts++;
        } else {
            $instance = new Ip();
            $instance->ip = $ip;
            $instance->attempts = 1;
        }
        $instance->save();
    }

    public function checkLoginAttempts(Request $request)
    {
        $ip = $request->ip();
        $instance = Ip::query()->firstOrCreate(['ip' => $ip]);
        $updatedAt = Carbon::parse($instance->updated_at);
        if ($updatedAt->diffInMinutes(now()) <= 15 && $instance->attempts >= 5) {
            return false;
        }
        if ($updatedAt->diffInHours(now()) <= 1) {
            if ($instance->attempts >= 15 && $updatedAt->diffInDays(now()) <= 1) {
                return false;
            }
        } else {
            $instance->attempts = 0;
            $instance->save();
        }
        return true;
    }
}