<?php

namespace App\Support;

class CourseStatusMapping
{
    public static array $statusLabels = [
        'draft' => [
            'label' => 'Draft',
            'bg-color' => 'bg-light text-body',
        ],
        'pending' => [
            'label' => 'Pending',
            'bg-color' => 'bg-warning text-white',
        ],
        'published' => [
            'label' => 'Published',
            'bg-color' => 'bg-success text-white',
        ],
        'rejected' => [
            'label' => 'Rejected',
            'bg-color' => 'bg-danger text-white',
        ],
    ];
}
