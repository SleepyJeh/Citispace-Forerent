<?php

namespace App\Livewire\Navbars;

use Livewire\Component;

class Navbar extends Component
{
    public $navigations = [
      [
          'label' => 'Home',
          'route' => 'landing.home',
      ],
      [
          'label' => 'Features',
          'route' => 'landing.features',
      ],
      [
          'label' => 'About',
          'route' => 'landing.about',
      ],
      [
          'label' => 'Contact',
          'route' => 'landing.contacts',
      ],
    ];


    public function getActiveClass($routeName)
    {
        return request()->routeIs($routeName)
            ? 'text-blue-700 bg-blue-50 md:bg-transparent md:text-blue-700 border-b border-blue-700'
            : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent';
    }

    public function render()
    {
        return view('livewire.navbars.nav-bar');
    }
}
