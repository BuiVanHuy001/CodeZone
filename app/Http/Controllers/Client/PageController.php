<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class PageController extends Controller
{
    public function index(): View|Application|Factory
    {
        $categories = Category::all();

        return view('client.pages.index', ['categories' => $categories]);
    }

    public function aboutUs(): View|Application|Factory
    {
        return view('client.pages.aboutUs');
    }
}
