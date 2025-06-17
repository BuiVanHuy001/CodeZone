<?php

namespace App\Http\Controllers\Client\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public string $activeComponent = '';

    protected array $listeners = ['componentSelected' => 'updateComponent'];

    public function updateComponent($component): void
    {
        $this->activeComponent = $component;
    }


    /**
     * Display the instructor's dashboard.
     *
     * @return View
     */
    public function index(): View
    {
        return view('livewire.client.dashboard.instructor.index');
    }
}
