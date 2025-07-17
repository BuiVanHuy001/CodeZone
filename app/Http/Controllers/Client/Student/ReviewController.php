<?php

namespace App\Http\Controllers\Client\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, string $type, string $id)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'content' => 'nullable|string|max:1000',
            'id_course' => 'required|exists:courses,id',
        ]);

        Review::create([
            'user_id'         => auth()->id(),
            'reviewable_type' => $type,
            'reviewable_id'   => $id,
            'rating'          => $request->rating,
            'content'         => $request->content,
            'id_course'       => $request->id_course,
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }



    public function index()
    {
        $user = Auth::user();

        // Review đã viết
        $reviewsGiven = Review::with('reviewable')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        // Review nhận được (ví dụ user là người sở hữu khóa học)
        $reviewsReceived = Review::with(['reviewable', 'user'])
            ->whereHasMorph('reviewable', ['App\Models\Course'], function ($query) use ($user) {
                $query->where('owner_id', $user->id); // bạn có thể đổi thành creator_id nếu cần
            })
            ->latest()
            ->get();

        return view('client.student.reviews.index', compact('reviewsGiven', 'reviewsReceived'));
    }
}
