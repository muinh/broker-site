<?php

namespace App\Console\Commands;

use App\Platforms\Bx8\Bx8Integrator;
use Illuminate\Console\Command;

class RenewAuthToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get oauth token';

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
        echo $client->getToken();
        return true;
    }
}
