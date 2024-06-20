<?php

namespace App\Tests\UnitTests;

use App\Services\PriceServices;
use App\Tests\Provider\Provider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    #[DataProviderExternal(Provider::class, 'PriceProvider')]
    public function testPriceService($price, $startDate, $brithDayDate, $payDate, $expectedResult): void
    {
        $mockCurrentDate = new \DateTime('01.01.2024');
        $priceServices = new PriceServices($mockCurrentDate);

        if (is_string($expectedResult) && class_exists($expectedResult)) {
            $this->expectException($expectedResult);
            $priceServices->priceCalculate($price, $startDate, $brithDayDate, $payDate);
        } else {
            $result = $priceServices->priceCalculate($price, $startDate, $brithDayDate, $payDate);
            $this->assertEquals($expectedResult, $result);
        }
    }
}
