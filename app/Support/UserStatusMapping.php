<?php

namespace App\Support;

class UserStatusMapping
{
    public static array $STATUSES = [
        'active' => [
            'label' => 'Active',
            'class' => 'bg-success text-white',
        ],
        'pending' => [
            'label' => 'Pending',
            'class' => 'bg-warning text-white',
        ],
        'banned' => [
            'label' => 'Banned',
            'class' => 'bg-danger text-white'
        ],
        'suspended' => [
            'label' => 'Suspended',
            'class' => 'bg-danger text-danger'
        ],
        'rejected' => [
            'label' => 'Rejected',
            'class' => 'bg-info text-white'
        ],
        'deleted' => [
            'label' => 'Deleted',
            'class' => 'bg-secondary text-secondary'
        ],
    ];
}
