<?php

namespace App\Http\Controllers\Client\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    //    public function store(Request $request, string $reviewable_type, string $reviewable_id)
    //    {
    //        $allowedTypes = [
    //            'builders' => Course::class,
    //            'lesson' => \App\Models\Lesson::class,
    //        ];
    //
    //        try {
    //            $request->validate([
    //                'rating'        => 'required|integer|min:1|max:5',
    //                'content'       => 'nullable|string|max:1000',
    //                'reviewable_id' => 'required|exists:courses,id',
    //                'reviewable_type' => ['required', Rule::in(array_keys($allowedTypes))],
    //            ]);
    //
    //            if (!isset($allowedTypes[$reviewable_type])) {
    //                return back()->with('error', 'Invalid reviewable type.');
    //            }
    //
    //            $model = $allowedTypes[$reviewable_type];
    //            if (!$model::where('id', $reviewable_id)->exists()) {
    //                return back()->with('error', 'Invalid reviewable ID.');
    //            }
    //
    //            Review::create([
    //                'user_id'         => auth()->id(),
    //                'rating'          => $request->rating,
    //                'content'         => $request->content,
    //                'reviewable_id'   => $reviewable_id,
    //                'reviewable_type' => $reviewable_type,
    //            ]);
    //
    //            return back()->with('success', 'Review submitted successfully!');
    //        } catch (\Throwable $e) {
    //            Log::error('Review Store Error', [
    //                'error_message' => $e->getMessage(),
    //                'trace'         => $e->getTraceAsString(),
    //                'user_id'       => auth()->id(),
    //                'request_data'  => $request->all()
    //            ]);
    //
    //            return back()->with('error', 'Something went wrong while submitting your review.');
    //        }
    //    }
}
