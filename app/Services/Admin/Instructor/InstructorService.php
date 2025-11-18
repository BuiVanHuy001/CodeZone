<?php

namespace App\Services\Admin\Instructor;

use App\Events\Instructor\ApprovedEvent;
use App\Events\Instructor\RejectedEvent;
use App\Events\Instructor\RestoredEvent;
use App\Events\Instructor\SuspendedEvent;
use App\Factories\InstructorFactory;
use App\Services\Client\Instructor\Catalog\CatalogService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

readonly class InstructorService {
    private CatalogService $catalogService;

    public function __construct()
    {
        $this->catalogService = app(CatalogService::class);
    }

    public function storeInstructor(array $data): void
    {
        app(InstructorFactory::class)->store($data);
    }

    public function suspendInstructor(string $instructorId): bool
    {
        $instructor = $this->getInstructorByIdAndStatus($instructorId, 'active');

        if ($instructor) {
            DB::transaction(function () use ($instructor) {
                $instructor->forceFill([
                    'status' => 'suspended',
                    'remember_token' => Str::random(60),
                ])->save();

                SuspendedEvent::dispatch($instructor);
            });

            return true;
        }
        return false;
    }

    public function approveInstructor(string $instructorId): bool
    {
        $instructor = $this->getInstructorByIdAndStatus($instructorId, 'pending');

        if ($instructor) {
            $instructor->update([
                'status' => 'active',
            ]);
            ApprovedEvent::dispatch($instructor);
            return true;
        }
        return false;
    }

    public function restoreInstructor(string $instructorId): bool
    {
        $instructor = $this->getInstructorByIdAndStatus($instructorId, 'suspended');
        if ($instructor) {
            $instructor->update([
                'status' => 'active',
            ]);
            RestoredEvent::dispatch($instructor);
            return true;
        }
        return false;
    }

    public function rejectInstructor(string $instructorId): bool
    {
        $instructor = $this->getInstructorByIdAndStatus($instructorId, 'pending');

        if ($instructor) {
            $instructor->update([
                'status' => 'rejected',
            ]);
            RejectedEvent::dispatch($instructor);

            return true;
        }
        return false;
    }

    private function getInstructorByIdAndStatus(string $instructorId, string $status): ?Model
    {
        return Role::findByName('instructor')->users()->where([
            'id' => $instructorId,
            'status' => $status,
        ])->first();
    }

    public function getInstructorsByStatus(string $status): Collection
    {
        return $this->catalogService->getDetailsForAdminList($status);
    }
}
