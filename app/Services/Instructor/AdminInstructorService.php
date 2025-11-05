<?php

namespace App\Services\Instructor;

use App\Services\Instructor\Catalog\CatalogService;
use Illuminate\Support\Collection;

readonly class AdminInstructorService
{
    private CatalogService $catalogService;

    public function __construct()
    {
        $this->catalogService = app(CatalogService::class);
    }

    public function getInstructorsByStatus(string $status): Collection
    {
        return $this->catalogService->getDetailsForAdminList($status);
    }
}
