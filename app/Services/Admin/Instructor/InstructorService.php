<?php

namespace App\Services\Admin\Instructor;

use App\DTOs\Instructor\InstructorDetailDTO;
use App\Events\Instructor\ApprovedEvent;
use App\Events\Instructor\RejectedEvent;
use App\Events\Instructor\RestoredEvent;
use App\Events\Instructor\SuspendedEvent;
use App\Factories\InstructorFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

readonly class InstructorService {
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

    public function getInstructorsByStatus(string $status, array $filters = []): LengthAwarePaginator
    {
        $query = User::role('instructor')
                     ->where('status', $status)
                     ->with(['instructorProfile', 'instructorProfile.major', 'instructorProfile.major.faculty']); // Eager Load để tránh N+1 Query

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['major_id'])) {
            $query->whereHas('instructorProfile', function ($q) use ($filters) {
                $q->where('major_id', $filters['major_id']);
            });
        } elseif (!empty($filters['faculty_id'])) {
            $query->whereHas('instructorProfile.major', function ($q) use ($filters) {
                $q->where('faculty_id', $filters['faculty_id']);
            });
        }

        $query->latest();

        return $query->paginate(10);
    }

    public function getInstructor(string $instructorId): ?InstructorDetailDTO
    {
        $user = User::role('instructor')
                    ->with(['instructorProfile.major.faculty'])
                    ->find($instructorId);

        if (!$user) {
            return null;
        }

        return InstructorDetailDTO::fromModel($user);
    }
}
