<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;

class ClientMenuMapping {
    public static function getMenuForRole(): array
    {
        $role = auth()->user()->getRoleNames()->first();

        $instance = new self();

        return $instance->menuMapping[$role] ?? [];
    }

    private array $menuMapping = [
        'instructor' => [
            0 => [
                'Tổng quan' => [
                    'icon' => 'feather-home',
                    'route' => 'instructor.dashboard.index',
                ],
                'Khóa học của tôi' => [
                    'icon' => 'feather-book-open',
                    'route' => 'instructor.dashboard.courses',
                ],
                'Hồ sơ cá nhân' => [
                    'icon' => 'feather-user',
                    'route' => 'instructor.dashboard.profile',
                ],
                'Đánh giá' => [
                    'icon' => 'feather-star',
                    'route' => 'instructor.dashboard.reviews',
                ]
            ],
            1 => [
                'Cài đặt tài khoản' => [
                    'icon' => 'feather-settings',
                    'route' => 'instructor.dashboard.settings',
                ],
            ]
        ],
        'student' => [
            0 => [
                'Tổng quan' => [
                    'icon' => 'feather-home',
                    'route' => 'student.dashboard.index',
                ],
                'Lớp học của tôi' => [
                    'icon' => 'feather-book-open',
                    'route' => 'student.dashboard.courses',
                ],
                'Hồ sơ cá nhân' => [
                    'icon' => 'feather-user',
                    'route' => 'student.dashboard.profile',
                ],
                'Lịch sử mua hàng' => [
                    'icon' => 'feather-shopping-bag',
                    'route' => 'student.dashboard.purchases',
                ],
                'Đánh giá đã gửi' => [
                    'icon' => 'feather-star',
                    'route' => 'student.dashboard.reviews',
                ]
            ],
            1 => [
                'Cài đặt tài khoản' => [
                    'icon' => 'feather-settings',
                    'route' => 'student.dashboard.settings',
                ],
            ]
        ],
        'admin' => [
            0 => [
                'Tổng quan' => [
                    'icon' => 'feather-home',
                    'route' => 'admin.overview.index',
                ],
                'Quản lý Giảng viên' => [
                    'icon' => 'feather-users',
                    'route' => 'admin.instructors.index',
                ],
                'Quản lý Sinh viên' => [
                    'icon' => 'feather-users',
                    'route' => 'admin.students.index',
                ],
                'Quản lý Phòng ban/Khoa' => [
                    'icon' => 'feather-users',
                    'route' => 'admin.academic.index',
                ]
            ]
        ]
    ];
}
