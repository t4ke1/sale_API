<?php

namespace App\DTO\Request;

use App\DTO\DTOResolvedInterface;
use Symfony\Component\Validator\Constraints as Assert;

class PriceDTO implements DTOResolvedInterface
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $price;

    #[Assert\NotBlank]
    #[Assert\DateTime(format: 'd.m.Y', message: 'The date must be in the format dd.mm.yyyy')]
    private string $startDate;

    #[Assert\NotBlank]
    #[Assert\DateTime(format: 'd.m.Y', message: 'The date must be in the format dd.mm.yyyy')]
    private string $brithDayDate;

    #[Assert\NotBlank]
    #[Assert\DateTime(format: 'd.m.Y', message: 'The date must be in the format dd.mm.yyyy')]
    private string $payDate;

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getBrithDayDate(): string
    {
        return $this->brithDayDate;
    }

    public function setBrithDayDate(string $brithDayDate): self
    {
        $this->brithDayDate = $brithDayDate;

        return $this;
    }

    public function getPayDate(): string
    {
        return $this->payDate;
    }

    public function setPayDate(string $payDate): self
    {
        $this->payDate = $payDate;

        return $this;
    }
}
