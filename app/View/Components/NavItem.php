<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavItem extends Component
{
    public $active;
    public $href;
    public $icon;
    public $text;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($active, $href, $icon, $text)
    {
        //
        $this->active = $active;
        $this->href = $href;
        $this->icon = $icon;
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.nav-item');
    }
}
