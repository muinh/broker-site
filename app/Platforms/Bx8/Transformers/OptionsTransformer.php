<?php

namespace App\Platforms\Bx8\Transformers;

use App\Broker;
use Carbon\Carbon;

class OptionsTransformer
{
    protected $broker;

    function __construct(Broker $broker)
    {
        $this->broker = $broker;
    }

    public function fromArray($options = [])
    {
        $newOptions = [];

        foreach ($options as $option) {
            $newOptions[] = $this->transform($option);
        }

        return $newOptions;
    }

    public function transform($option)
    {
        $start = Carbon::parse(array_get($option, 'startTime'));
        $end = Carbon::parse(array_get($option, 'endTime'));

        return [
            "broker_id"     =>  $this->broker->id,
            "external_id"   =>  $option["id"],
            "asset_id"      =>  $option["id"],
            "asset_type"    =>  null,
            "asset_name"    =>  $option["assetName"],
            "start_date"    =>  $start,
            "end_date"      =>  $end,
            "profit"        =>  array_get($option, 'winPayout', 0.7) * 100,
            "direction"     =>  rand(0,1) == 1 ? true : false,
            "is_enabled"    =>  true,
            "is_short"      =>  true
        ];
    }
}