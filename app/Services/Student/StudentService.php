<?php

namespace App\Services\Student;

use App\Models\Order;
use App\Models\User;
use App\Traits\HasNumberFormat;
use Illuminate\Support\Collection;

readonly class StudentService
{
    use HasNumberFormat;

    public function prepareDetails(User $student): User
    {
        $profile = $student->studentProfile;

        $student->avatar = $student->getAvatarPath();
        $student->enrolledCountText = $this->formatCount($profile?->enrolled_count ?? 0, 'course');
        $student->completedCountText = $this->formatCount($profile?->completed_count ?? 0, 'course');
        return $student;
    }


    public function prepareProfile(User $user): array
    {
        $infos = [
            'Full Name' => $user->name,
            'Email' => $user->email,
            'Register Date' => $user->created_at->diffForHumans(),
        ];
        if ($user->studentProfile) {
            $infos = array_merge($infos, [
                'Date Of Birth' => $user->studentProfile->dob ? $user->studentProfile->dob->format('d/m/Y') : 'N/A',
                'Gender' => $user->studentProfile->gender === 0 ? 'Male' : 'Female',
                'Enrolled Course Amount' => $user->studentProfile->enrolled_count,
                'Completed Course Amount' => $user->studentProfile->completed_count,
            ]);

            if ($user->studentProfile->addition_data) {
                $infos = array_merge($infos, $user->studentProfile->addition_data);
            }
        }
        return $infos;
    }

    public function getPurchases(): Collection
    {
        $orders = Order::where('user_id', auth()->id())
            ->whereNot('status', 'cart')
            ->with('items.course')
            ->latest()->get();
        $orders->map(function (Order $order) { $this->decorateData($order); });
        return $orders;
    }

    private function decorateData(Order $order): void
    {

        $order->totalPriceText = $this->formatCurrency($order->total_price);
        $order->status = ucfirst($order->status);
        $order->courses = $order->items->map(fn($item) => $item->course)->filter();
    }
}
