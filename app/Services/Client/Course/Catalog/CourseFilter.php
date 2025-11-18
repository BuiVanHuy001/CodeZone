<?php

namespace App\Services\Client\Course\Catalog;

use App\Models\Course;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseFilter
{
    public function filterCourse(int $amount, Request $request): LengthAwarePaginator
    {
        $query = Course::query()
            ->where('status', 'published')
            ->with(['author', 'reviews', 'category']);

        $this->applySearch($query, $request->input('search'));
        $this->applyCategory($query, $request->input('category'));
        $this->applyInstructor($query, $request->input('instructor'));
        $this->applyOffer($query, $request->input('offer'));
        $this->applyPriceRange($query, $request->input('price_min'), $request->input('price_max'));
        $this->applySorting($query, $request->input('short_by'));

        return $query->paginate($amount)->withQueryString();
    }

    private function applySearch(Builder $query, ?string $search): void
    {
        if (blank($search)) {
            return;
        }

        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('heading', 'like', "%{$search}%")
                ->orWhere('skills', 'like', "%{$search}%")
                ->orWhere('requirements', 'like', "%{$search}%")
                ->orWhere('target_audiences', 'like', "%{$search}%");
        });
    }

    private function applyCategory(Builder $query, ?string $category): void
    {
        if ($category === 'all' || blank($category)) {
            return;
        }

        $query->where('category_id', $category);
    }

    private function applyInstructor(Builder $query, string|array|null $instructor): void
    {
        if ($instructor === 'all' || blank($instructor)) {
            return;
        }

        $ids = collect(is_array($instructor) ? $instructor : explode(',', (string)$instructor))
            ->map(fn($id) => (int)trim($id))
            ->filter(fn($id) => $id > 0)
            ->unique()
            ->values();

        if ($ids->isNotEmpty()) {
            $query->whereIn('user_id', $ids);
        }
    }

    private function applyOffer(Builder $query, ?string $offer): void
    {
        match ($offer) {
            'free' => $query->where('price', 0),
            'paid' => $query->where('price', '>', 0),
            default => null,
        };
    }

    private function applyPriceRange(Builder $query, $min, $max): void
    {
        if (is_numeric($min)) {
            $query->where('price', '>=', (float)$min);
        }

        if (is_numeric($max)) {
            $query->where('price', '<=', (float)$max);
        }
    }

    private function applySorting(Builder $query, ?string $sortBy): void
    {
        match ($sortBy) {
            'latest' => $query->orderBy('created_at', 'desc'),
            'oldest' => $query->orderBy('created_at'),
            'a-z' => $query->orderBy('title'),
            'z-a' => $query->orderBy('title', 'desc'),
            'price-low-to-high' => $query->orderBy('price'),
            'price-high-to-low' => $query->orderBy('price', 'desc'),
            default => $query
                ->orderByDesc('enrollment_count')
                ->orderByDesc('review_count')
                ->orderByDesc('rating'),
        };
    }
}
