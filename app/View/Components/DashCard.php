<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashCard extends Component
{
    public $title;
    public $icon;
    public $color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $icon, $color)
    {
        //
        $this->title = $title;
        $this->icon = $icon;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dash-card');
    }
}
