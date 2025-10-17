<?php

namespace App\Support;

class CourseFilter
{
    public static array $shortByOptions = [
        'popular' => 'Most Popular',
        'latest' => 'Latest',
        'oldest' => 'Oldest',
        'a-z' => 'A-Z',
        'z-a' => 'Z-A',
        'price-low-to-high' => 'Price: Low to High',
        'price-high-to-low' => 'Price: High to Low',
    ];

    public static array $offerOptions = [
        'all' => 'All',
        'free' => 'Free',
        'paid' => 'Paid',
    ];
}
