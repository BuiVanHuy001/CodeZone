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

    public function formatCount(int $count, string $word): string
    {
        return $count . ' ' . str($word)->plural($count);
    }

    public function getFormattedParts(float $number): array
    {
        if ($number < 1000) {
            return ['number' => number_format($number, 0), 'suffix' => ''];
        } elseif ($number < 1000000) {
            return [
                'number' => number_format($number / 1000, 1),
                'suffix' => 'k'
            ];
        } elseif ($number < 1000000000) {
            return [
                'number' => number_format($number / 1000000, 2),
                'suffix' => 'M'
            ];
        } else {
            return [
                'number' => number_format($number / 1000000000, 2),
                'suffix' => 'B'
            ];
        }
    }
}
