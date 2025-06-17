<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class page extends Component
{

    public $show_index_button;
    public $show_create_button;
    public $show_edit_button;
    public $show_delete_button;

    public $title;
    public $module;

    public function __construct(
        $show_index_button = false,
        $show_create_button = false,
        $show_edit_button = false,
        $show_delete_button = false,
        $title = '',
        $module = '',
    ) {
        $this->show_index_button = $show_index_button;
        $this->show_create_button = $show_create_button;
        $this->show_edit_button = $show_edit_button;
        $this->show_delete_button = $show_delete_button;
        $this->title = $title;
        $this->module = $module;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.page');
    }
}
