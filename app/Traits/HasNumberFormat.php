<?php

namespace App\Traits;

trait HasNumberFormat
{
    public function formatShort(int|float $number): string
    {
        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        }
        if ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        }
        return (string)$number;
    }

    public function formatNumber(int|float $number): string
    {
        return number_format($number, 0, ',', '.');
    }

    public function formatCurrency(int|float $number, string $symbol = '₫'): string
    {
        return number_format($number, 0, ',', '.') . $symbol;
    }

}
