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
        public $show_index_button = false,
        public $show_create_button = false,
        public $show_edit_button = false,
        public $show_delete_button = false,

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
