<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class page extends Component
{

    /**
     * Create a new component instance.
     */
    public function __construct(
        public $showIndexButton = false,
        public $showCreateButton = false,
        public $showEditButton = false,
        public $showDeleteButton = false,

        public $title = '',
        public $module = '',
    ){}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.page');
    }
}
