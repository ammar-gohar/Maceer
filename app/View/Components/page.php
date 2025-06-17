<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class page extends Component
{

    public function __construct(
        $show_index_button = false,
        $show_create_button = false,
        $show_edit_button = false,
        $show_delete_button = false,
        $title = '',
        $module = '',
    ) {
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.page');
    }
}
