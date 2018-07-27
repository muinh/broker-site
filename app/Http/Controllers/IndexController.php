<?php
namespace App\Http\Controllers;

use App\Mail\UploadDocs;
use App\Models\DocsData;
use App\Models\Page;
use App\Platforms\Bx8\Bx8Integrator;
use Illuminate\Http\Request;
use App\Helpers\ScheduleCall;

class IndexController extends Controller
{
    public function index($slug = 'index')
    {
        $page = Page::query()->where('url', '=', $slug)->first();
        $title = array_get($page, 'title') ? array_get($page, 'title') . ' - ' . config('app.name') : config('app.name');
        return view('layouts.app', compact('title'));
    }

    public function deposit(Request $request)
    {
        if ($request->get('status') === 'approved') {
            return redirect('/my-account?action=paymentSuccess#deposit');
        } else {
            return redirect('/my-account?action=paymentFail#deposit');
        }
    }

    public function autoLogin()
    {
        return view('autoLogin');
    }

    public function postAutoLogin(Request $request)
    {
        /** @var Bx8Integrator $client */
        $client = app()->make('bx8');
        $credentials = collect($request->only(['email', 'password']))->values();
        $token = $client->accountLogin(...$credentials);
        return compact('token');
    }

    public function scheduleForm(Request $request)
    {
        $this->validate($request, [
            "firstName" => "required|min:2",
            "lastName" => "required|min:2",
            "phone" => "required",
            "age" => "required|integer|min:18|max:150"
        ], [
            "firstName.required" => "First name is required.",
            "firstName.min" => "First name must be at least 2 characters.",
            "lastName.required" => "Last name is required.",
            "lastName.min" => "Last name must be at least 2 characters.",
            "phone.required" => "Phone is required.",
            "age.required" => "Age is required.",
            "age.integer" => "Age must be a number.",
            "age.min" => "You have to be over 18 years old to request a phone call."
        ]);
        ScheduleCall::sendQueryMail($request);
        return ['message' => 'Thank you for your message. We will reply soon.'];
    }

    public function uploadForm(Request $request)
    {
        $this->validate($request, [
            "id" => "required",
            "FirstName" => "required",
            "LastName" => "required",
            "passport" => "required|file|max:5000",
            "creditCardFront" => "required|file|max:5000",
            "creditCardBack" => "required|file|max:5000",
            "utilityBill" => "required|file|max:5000",
        ], [
            "firstName.required" => "First name is required.",
            "lastName.required" => "Last name is required."
        ]);
        \Mail::to(env('MAIL_DOCS_EMAIL'))->sendNow(new UploadDocs(new DocsData($request->all())));
        return ['message' => 'Thank you for your message. We will reply soon.'];
    }

    public function captcha()
    {
        return app('captcha')->create('flat', true);
    }

    public function isAccessAllowed()
    {
        return response(['status' => (is_allowed_country() || is_allowed_ip())] );
    }
}
