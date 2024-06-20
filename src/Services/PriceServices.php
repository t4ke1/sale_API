<?php

namespace App\Services;

use App\Exception\BadDataException;

class PriceServices
{
    public function __construct(
        private readonly \DateTime $currentDate = new \DateTime(),
    ) {
    }

    /**
     * @throws BadDataException
     */
    public function priceCalculate($price, $startDate, $brithDayDate, $payDate): int
    {
        if (null == $price || null == $startDate || null == $brithDayDate || null == $payDate) {
            throw new BadDataException();
        }

        $startDateObject = \DateTime::createFromFormat('d.m.Y', $startDate);
        $brithDayDataObject = \DateTime::createFromFormat('d.m.Y', $brithDayDate);
        $payDataObject = \DateTime::createFromFormat('d.m.Y', $payDate);

        $intPrice = (int) $price;
        $currentYearOject = $this->currentDate;
        $year = (int) $currentYearOject->format('Y');
        $nextYear = $year + 1;
        $currentYear = $year;

        if ($startDateObject < $currentYearOject || $payDataObject < $currentYearOject) {
            throw new BadDataException();
        }

        $firstAprilNextYear = \DateTime::createFromFormat('d.m.Y', "01.04.$nextYear");
        $thirtiethNovemberNextYear = \DateTime::createFromFormat('d.m.Y', "30.11.$nextYear");
        $payNovemberThisYear = \DateTime::createFromFormat('d.m.Y', "30.11.$currentYear");
        $payDecemberThisYear = \DateTime::createFromFormat('d.m.Y', "31.12.$currentYear");
        $payJanuaryNextYear = \DateTime::createFromFormat('d.m.Y', "31.01.$nextYear");

        $fistOctoberNextYear = \DateTime::createFromFormat('d.m.Y', "01.10.$currentYear");
        $fourteenthJanuaryNextYear = \DateTime::createFromFormat('d.m.Y', "14.01.$nextYear");
        $payMarchThisYear = \DateTime::createFromFormat('d.m.Y', "31.03.$currentYear");
        $payAprilThisYear = \DateTime::createFromFormat('d.m.Y', "30.04.$currentYear");
        $payMayThisYear = \DateTime::createFromFormat('d.m.Y', "31.05.$currentYear");

        $fifteenthJuneNextYear = \DateTime::createFromFormat('d.m.Y', "15.06.$nextYear");
        $payAugustThisYear = \DateTime::createFromFormat('d.m.Y', "31.08.$currentYear");
        $paySeptemberThisYear = \DateTime::createFromFormat('d.m.Y', "30.09.$currentYear");
        $payOctoberThisYear = \DateTime::createFromFormat('d.m.Y', "31.10.$currentYear");

        $paySale = 0;
        if ($firstAprilNextYear <= $startDateObject && $startDateObject <= $thirtiethNovemberNextYear) {
            if ($payDataObject <= $payNovemberThisYear) {
                $paySale = 7;
            } elseif ($payDataObject <= $payDecemberThisYear) {
                $paySale = 5;
            } elseif ($payDataObject <= $payJanuaryNextYear) {
                $paySale = 3;
            }
        } elseif ($startDateObject >= $fistOctoberNextYear && $startDateObject <= $fourteenthJanuaryNextYear) {
            if ($payDataObject <= $payMarchThisYear) {
                $paySale = 7;
            } elseif ($payDataObject <= $payAprilThisYear) {
                $paySale = 5;
            } elseif ($payDataObject <= $payMayThisYear) {
                $paySale = 3;
            }
        } elseif ($startDateObject <= $fifteenthJuneNextYear) {
            if ($payDataObject <= $payAugustThisYear) {
                $paySale = 7;
            } elseif ($payDataObject <= $paySeptemberThisYear) {
                $paySale = 5;
            } elseif ($payDataObject <= $payOctoberThisYear) {
                $paySale = 3;
            }
        }

        $preOrderSale = $intPrice - ($intPrice * (100 - $paySale) / 100);
        if ($preOrderSale > 1500) {
            $preOrderSale = 1500;
        }

        $currentDate = new \DateTime();
        $currentYear = $currentDate->format('Y');
        $currentMonth = $currentDate->format('m');
        $currentDay = $currentDate->format('d');

        $brithDayYear = $brithDayDataObject->format('Y');
        $brithDayMonth = $brithDayDataObject->format('m');
        $brithDayDay = $brithDayDataObject->format('d');

        $age = $currentYear - $brithDayYear;
        if ($currentMonth < $brithDayMonth) {
            ++$age;
        } elseif ($currentMonth == $brithDayMonth && $currentDay <= $brithDayDay) {
            ++$age;
        }
        if ($age >= 3 && $age < 6) {
            $ageSale = 80;
            $maxSale = PHP_INT_MAX;
        } elseif ($age >= 6 && $age < 12) {
            $ageSale = 30;
            $maxSale = 4500;
        } elseif ($age >= 12 && $age < 18) {
            $ageSale = 10;
            $maxSale = PHP_INT_MAX;
        } else {
            $ageSale = 0;
            $maxSale = PHP_INT_MAX;
        }

        $ageSale = $intPrice - ($intPrice * (100 - $ageSale) / 100);
        if ($ageSale > $maxSale) {
            $ageSale = $maxSale;
        }

        return $intPrice - $preOrderSale - $ageSale;
    }
}
