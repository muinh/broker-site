<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Platforms\Bx8\Bx8Integrator;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;

class GrabCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grab:customers {--days=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab recent customers';

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
        $lastId = Setting::query()->where('key', '=', 'csv.last_lead')->first();
        $query = DB::connection('outer-replica')->table('customers as cu')
            ->selectRaw('cu.id, cu.FirstName, cu.LastName, cu.email as Email, cu.phone as PhoneNumber, co.iso 
            as CountryISO, cu.currency as Currency')
            ->leftJoin('country as co', 'co.id', '=', 'cu.Country')
            ->where('cu.FirstName', 'NOT LIKE', '%test%')
            ->where('cu.FirstName', 'NOT LIKE', '%demo%')
            ->where('cu.LastName', 'NOT LIKE', '%test%')
            ->where('cu.LastName', 'NOT LIKE', '%demo%')
            ->where('cu.email', 'NOT LIKE', '%test%')
            ->where('cu.email', 'NOT LIKE', '%demo%');
        if ($lastId) {
            $query->where('cu.id', '>', $lastId->value);
        } else {
            if (!$this->option('days')) {
                echo 'Please append parameter to the console command with NUM as integer --days=NUM';
                return '';
            }
            $query->where('cu.regTime', '>', Carbon::now()->subDays($this->option('days')));
        }
        $data = $query->orderBy('cu.regTime')->get();
        if (!count($data)) {
            echo 'No new users found';
            return '';
        }
        $client->setLastLead($data->pop()->id);
        $totalRegistered = $data->map(function ($item) use($client) {
            return $client->registerLead($item);
        });
        $totalRegistered = array_sum($totalRegistered->toArray());
        echo $totalRegistered ? $totalRegistered . ' leads added.' : 'No new leads found.';
        return '';
    }
}
