<?php

namespace App\Support;

class CourseStatusMapping
{
    public static array $statusLabels = [
        'draft' => [
            'label' => 'Draft',
            'bg-color' => 'bg-light text-body',
            'color' => 'secondary',
        ],
        'pending' => [
            'label' => 'Pending',
            'bg-color' => 'bg-warning text-white',
            'color' => 'warning',
        ],
        'published' => [
            'label' => 'Published',
            'bg-color' => 'bg-success text-white',
            'color' => 'success',
        ],
        'rejected' => [
            'label' => 'Rejected',
            'bg-color' => 'bg-danger text-white',
            'color' => 'danger',
        ],
        'suspended' => [
            'label' => 'Suspended',
            'bg-color' => 'bg-dark text-white',
            'color' => 'dark',
        ],
    ];
}
