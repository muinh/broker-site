<?php

namespace App\Platforms\Bx8\Transformers;

class PositionsTransformer
{
    public function fromArray($positions = [])
    {
        $newPositions = [];

        foreach ($positions as $position) {
            $newPositions[] = $this->getData($position);
        }

        return $newPositions;
    }

    public function getData($position)
    {
        $profit = array_get($position, 'profit');
        $amount = array_get($position, 'amount');
        if ($profit === null) {
            $status = 'Active';
        } elseif($profit > $amount) {
            $status = 'Won';
        } else {
            $status = 'Lost';
        }
        return [
            "external_id" => $position["id"],
            "status" => $status,
            "payout" => $profit,
        ];
    }
}