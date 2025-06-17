<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class page extends Component
{

    public $show_index_button = false;
    public $show_create_button = false;
    public $show_edit_button = false;
    public $show_delete_button = false;

    public $title = '';
    public $module = '';


    /**
     * Create a new component instance.
     */
    public function __construct($show_index_button = false, $show_create_button = false, $show_edit_button = false, $show_delete_button = false, $title = '', $module = ''){
        $this->module = $module;
        $this->title = $title;
        $this->show_index_button = $show_index_button;
        $this->show_edit_button = $show_edit_button;
        $this->show_create_button = $show_create_button;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.page');
    }
}
