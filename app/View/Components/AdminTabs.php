<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminTabs extends Component
{
    public function __construct(
        public array $tabs = [],
        public string $active = ''
    ) {}

    public function render()
    {
        return view('components.admin-tabs');
    }
}
