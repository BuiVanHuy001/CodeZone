<?php

namespace App\Services\Course;

use App\Models\User;
use App\Services\Course\Create\CreateService;

readonly class ManagementService
{
    public function __construct(
        private CreateService $createCourseService,
    )
    {
    }


}
