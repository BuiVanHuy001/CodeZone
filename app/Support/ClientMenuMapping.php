<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;

class ClientMenuMapping {
    public static function getMenuForRole(): array
    {
        $role = auth()->user()->getRoleNames()->first();
        Log::info($role, [auth()->user()->getRoleNames()]);
        $instance = new self();
        return $instance->menuMapping[$role] ?? [];
    }

    private array $menuMapping = [
        'instructor' => [
            0 => [
                'Overview' => [
                    'icon' => 'feather-home',
                    'route' => 'instructor.dashboard.index',
                ],
                'My Courses' => [
                    'icon' => 'feather-book-open',
                    'route' => 'instructor.dashboard.courses',
                ],
                'My Profile' => [
                    'icon' => 'feather-user',
                    'route' => 'instructor.dashboard.profile',
                ],
                'My Reviews' => [
                    'icon' => 'feather-star',
                    'route' => 'instructor.dashboard.reviews',
                ]
            ],
            1 => [
                'Account Settings' => [
                    'icon' => 'feather-settings',
                    'route' => 'instructor.dashboard.settings',
                ],
            ]
        ],
        'student' => [
            0 => [
                'Overview' => [
                    'icon' => 'feather-home',
                    'route' => 'student.dashboard.index',
                ],
                'My Learning' => [
                    'icon' => 'feather-book-open',
                    'route' => 'student.dashboard.courses',
                ],
                'My Profile' => [
                    'icon' => 'feather-user',
                    'route' => 'student.dashboard.profile',
                ],
                'My Purchases' => [
                    'icon' => 'feather-shopping-bag',
                    'route' => 'student.dashboard.purchases',
                ],
                'My Reviews' => [
                    'icon' => 'feather-star',
                    'route' => 'student.dashboard.reviews',
                ]
            ],
            1 => [
                'Account Settings' => [
                    'icon' => 'feather-settings',
                    'route' => 'student.dashboard.settings',
                ],
            ]
        ],
        'admin' => [
            0 => [
                'Overview' => [
                    'icon' => 'feather-home',
                    'route' => 'admin.overview.index',
                ],
                'Instructor' => [
                    'icon' => 'feather-users',
                    'route' => 'admin.instructors.index',
                ],
                'Student' => [
                    'icon' => 'feather-users',
                    'route' => 'admin.students.index',
                ],
                'Quản lý khoa' => [
                    'icon' => 'feather-users',
                    'route' => 'admin.academic.index',
                ]
            ]
        ]
    ];
}
