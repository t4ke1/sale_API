<?php

namespace App\Tests\Provider;

use App\Exception\BadDataException;

final class Provider
{
    public static function PriceProvider(): array
    {
        // $price, $startDate, $brithDayDate, $payDate, $expectedResult
        return [
            'StartDate < pay date' => [100, '01.01.2022', '01.01.2022', '01.01.2024', BadDataException::class],
            'StartDate < current date' => [100, '01.01.2022', '01.01.2022', '01.01.2023', BadDataException::class],
            'PayDate < current date' => [100, '01.01.2024', '01.01.2022', '01.01.2023', BadDataException::class],

            // startDate from 01.04. to 30.09 next year (18+)
            'payDate <= november this year(7%)' => [10000,  '01.05.2025', '01.01.2000', '01.11.2024', 9300],
            'payDate in december this year(5%)' => [10000,  '01.05.2025', '01.01.2000', '10.12.2024', 9500],
            'payDate in january next year(3%)' => [10000,  '01.05.2025', '01.01.2000', '10.01.2025', 9700],

            // startDate from 01.10 this year to 14.01 next year (18+)
            'payDate <= march this year(7%)' => [10000,  '10.01.2025', '01.01.2000', '10.03.2024', 9300],
            'payDate in april this year(5%)' => [10000,  '10.01.2025', '01.01.2000', '10.04.2024', 9500],
            'payDate in may this year(3%)' => [10000,  '10.01.2025', '01.01.2000', '10.05.2024', 9700],

            // startDate from 15.01 next year++ (18+);
            'payDate <= august this year(7%)' => [10000,  '15.02.2025', '01.01.2000', '10.08.2024', 9300],
            'payDate in september this year(5%)' => [10000,  '15.02.2025', '01.01.2000', '10.09.2024', 9500],
            'payDate in october this year(3%)' => [10000,  '15.02.2025', '01.01.2000', '10.10.2024', 9700],

            // year (18+) and sale > 1500;
            'payDate <= november this year(7%) and sale > 1500' => [30000,  '01.05.2025', '01.01.2000', '01.11.2024', 28500],
            'payDate <= march this year(7%) and sale > 1500' => [30000,  '10.01.2025', '01.01.2000', '10.03.2024', 28500],
            'payDate <= august this year(7%) and sale > 1500' => [30000,  '15.02.2025', '01.01.2000', '10.08.2024', 28500],

            'payDate in december this year(5%) and sale > 1500' => [40000,  '01.05.2025', '01.01.2000', '10.12.2024', 38500],
            'payDate in april this year(5%) and sale > 1500' => [40000,  '10.01.2025', '01.01.2000', '10.04.2024', 38500],
            'payDate in september this year(5%) and sale > 1500' => [40000,  '15.02.2025', '01.01.2000', '10.09.2024', 38500],

            'payDate in january next year(3%) and sale > 1500' => [60000,  '01.05.2025', '01.01.2000', '10.01.2025', 58500],
            'payDate in may this year(3%) and sale > 1500' => [60000,  '10.01.2025', '01.01.2000', '10.05.2024', 58500],
            'payDate in october this year(3%) and sale > 1500' => [60000,  '15.02.2025', '01.01.2000', '10.10.2024', 58500],

            // year < 3 (0%);
            'payDate <= march this year(7%), year 0(0%)' => [10000,  '10.01.2025', '01.01.2024', '10.03.2024', 9300],
            'payDate <= march this year(7%), year 1(0%)' => [10000,  '10.01.2025', '01.01.2023', '10.03.2024', 9300],
            'payDate <= march this year(7%), year 2(0%)' => [10000,  '10.01.2025', '01.01.2022', '10.03.2024', 9300],

            // 3 <= year < 6 (80%);
            'payDate <= march this year(7%) year 3 ' => [10000,  '10.01.2025', '02.01.2021', '10.03.2024', 1300],
            'payDate <= march this year(7%) year 4 ' => [10000,  '10.01.2025', '01.01.2020', '10.03.2024', 1300],
            'payDate <= march this year(7%) year 5 ' => [10000,  '10.01.2025', '01.01.2019', '10.03.2024', 1300],

            // 6 <= year < 12 (30% and maxSale = 4500)
            'payDate in april this year(5%), year 6' => [40000,  '10.01.2025', '01.01.2018', '10.04.2024', 34000],
            'payDate in april this year(5%), year 7' => [30000,  '10.01.2025', '01.01.2017', '10.04.2024', 24000],
            'payDate in april this year(5%), year 8' => [20000,  '10.01.2025', '01.01.2016', '10.04.2024', 14500],
            'payDate in april this year(5%), year 9' => [10000,  '10.01.2025', '01.01.2015', '10.04.2024', 6500],
            'payDate in april this year(5%), year 10' => [5000,  '10.01.2025', '01.01.2014', '10.04.2024', 3250],
            'payDate in april this year(5%), year 11' => [1000,  '10.01.2025', '01.01.2013', '10.04.2024', 650],

            // 12 <= year <18 (10%)
            'payDate in january next year(3%), year 12' => [60000,  '01.05.2025', '01.01.2012', '10.01.2025', 52500],
            'payDate in january next year(3%), year 13' => [40000,  '01.05.2025', '01.01.2011', '10.01.2025', 34800],
            'payDate in january next year(3%), year 14' => [30000,  '01.05.2025', '01.01.2010', '10.01.2025', 26100],
            'payDate in january next year(3%), year 15' => [20000,  '01.05.2025', '01.01.2009', '10.01.2025', 17400],
            'payDate in january next year(3%), year 16' => [10000,  '01.05.2025', '01.01.2008', '10.01.2025', 8700],
            'payDate in january next year(3%), year 17' => [5000,  '01.05.2025', '01.01.2007', '10.01.2025', 4350],
        ];
    }
}
