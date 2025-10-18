<?php

namespace App\Livewire\Client\Shared;

use App\Services\Reaction\ReactionService;
use App\Traits\HasNumberFormat;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ReactionBox extends Component
{
    use HasNumberFormat;

    private readonly ReactionService $reactionService;
    public Model $model;
    public string $titleText;
    public string $likeCount = '0';
    public string $dislikeCount = '0';
    public ?string $userReaction = null;

    public function boot(): void
    {
        $this->reactionService = app(ReactionService::class);
    }

    public function mount(string $titleText = ''): void
    {
        $this->titleText = $titleText;
        $this->loadData();
    }

    public function handleReaction(string $type): void
    {
        $this->reactionService->store($this->model, $type);
        $this->model->refresh();
        $this->loadData();
    }

    private function loadData(): void
    {
        $this->likeCount = $this->formatShort($this->model->like_count ?? 0);
        $this->dislikeCount = $this->formatShort($this->model->dislike_count ?? 0);

        $this->userReaction = $this->model->userReaction ?? null;
    }

    public function render(): View
    {
        return view('livewire.client.shared.reaction-box');
    }
}
