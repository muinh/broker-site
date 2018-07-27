<?php

namespace App\Console\Commands;

use App\Jobs\SendEmailJob;
use App\Platforms\Bx8\Bx8Integrator;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Mail;

class NotifyDepositors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:depositors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue emails to depositors';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var Bx8Integrator $client */
        $client = app()->make('bx8');
        try {
            $deposits = $client->getLastDeposits();
            foreach ($deposits as $deposit) {
                $accountId = array_get($deposit, 'accountId');
                if ($accountId) {
                    $customer = $client->getCustomerById($accountId);
                    $email = array_get($customer, 'email');
                    $firstName = array_get($customer, 'FirstName');
                    $lastName = array_get($customer, 'LastName');
                    $params = collect($deposit)->merge(compact('email', 'firstName', 'lastName'))->only(['email', 'firstName', 'lastName', 'amount', 'date', 'currency'])->toArray();
                    Mail::send('emails.deposit', $params, function($message) use($email) {
                        $message->from(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
                        $message->to($email);
                    });
                }
            }
        } catch (\Exception $exception) {

        }
        return true;
    }
}
