<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class Navbar extends Component
{

    public function getActiveClass($route)
    {
        return request()->is($route)
            ? 'text-blue-700 bg-blue-50 md:bg-transparent md:text-blue-700 border-b border-b-2 border-blue-700'
            : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent';
    }

    public function render()
    {
        return view('layouts.common-navbar');
    }
}
