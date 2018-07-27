<?php

namespace App\Platforms\Bx8\Transformers;

class CustomerTransformer
{
    public function fromArray($customers = [])
    {
        $newCustomers = [];

        foreach ($customers as $customer) {
            $newCustomers[] = $this->get($customer);
        }

        return $newCustomers;
    }

    public function get($customer)
    {
        return [
            'id' => $customer['id'],
            'email' => $customer['email'],
            'FirstName' => $customer['firstName'],
            'LastName' => $customer['lastName'],
            'phone' => $customer['phoneNumber'],
            'accountBalance' => $customer['balance'],
            'currency' => $customer['currency'],
            'country' => $customer['countryIso']
        ];
    }
}