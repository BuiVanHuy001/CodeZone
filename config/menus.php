<?php

return [
	'organization' => [
		0 => [
			'Overview' => [
				'icon' => 'feather-home',
				'route' => 'organization.dashboard.overview',
			],
			'My Courses' => [
				'icon' => 'feather-book-open',
				'route' => 'organization.dashboard.courses',
			],
			'My Member' => [
				'icon' => 'feather-users',
				'route' => 'organization.dashboard.members',
			],
		],
		1 => [
			'Account Settings' => [
				'icon' => 'feather-settings',
				'route' => 'organization.dashboard.settings',
			],
		]

	],
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
	]
];
