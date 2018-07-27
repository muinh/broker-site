<?php

namespace App\Jobs;

use App\Mail\DepositCustomer;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $deposit;
    protected $customer;

    /**
     * Create a new job instance.
     *
     * @param $deposit
     * @param $customer
     */
    public function __construct($deposit, $customer)
    {
        $this->deposit = $deposit;
        $this->customer = $customer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = array_get($this->customer, 'email');
        $firstName = array_get($this->customer, 'FirstName');
        $lastName = array_get($this->customer, 'LastName');
        $params = collect($this->deposit)->merge(compact('email', 'firstName', 'lastName'))->only(['email', 'firstName', 'lastName', 'amount', 'date', 'currency']);
        if ($email) {
            \Mail::to($email)->send(new DepositCustomer($params));
        }
    }
}
