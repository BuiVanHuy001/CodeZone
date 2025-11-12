<?php

namespace App\Services\Instructor;

use App\Models\User;
use App\Services\Instructor\Catalog\CatalogService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

readonly class AdminInstructorService
{
    private CatalogService $catalogService;

    public function __construct()
    {
        $this->catalogService = app(CatalogService::class);
    }

    public function suspendInstructor(string $instructorId): bool
    {
        $instructor = User::findOrFail($instructorId);

        DB::transaction(function () use ($instructor) {
            $instructor->forceFill([
                'status' => 'suspended',
                'remember_token' => Str::random(60),
            ])->save();

            $this->invalidateUserSessions($instructor);
        });

        return true;
    }

    private function invalidateUserSessions(User $user): void
    {
        $driver = Config::get('session.driver');

        if ($driver === 'database') {
            $table = Config::get('session.table', 'sessions');
            DB::table($table)->where('user_id', $user->getAuthIdentifier())->delete();
        }
    }

    public function getInstructorsByStatus(string $status): Collection
    {
        return $this->catalogService->getDetailsForAdminList($status);
    }
}
