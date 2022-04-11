<?php

namespace tests;

use PHPUnit\Framework\TestCase as TestCase;
use Services\CalculateCommission\CalculateCommission;

class CalculateCommissionTest extends TestCase
{

    public function testCorrectInputDataIsReturned()
    {
        $input = file_get_contents("input.txt");

        $expected = [
            ["bin" => "45717360", "amount" => 100.00, "currency" => "EUR" ],
            ["bin" => "516793", "amount" => 50.00, "currency" => "USD" ],
            ["bin" => "45417360", "amount" => 10000.00, "currency" => "JPY" ],
            ["bin" => "41417360", "amount" => 130.00, "currency" => "USD" ],
            ["bin" => "4745030", "amount" => 2000.00, "currency" => "GBP" ]
        ];

        $commission = new CalculateCommission();

        $actual = $commission->get_commission_data($input);

        $this->assertEqualsCanonicalizing(
            $expected,
            $actual
        );
    }

}