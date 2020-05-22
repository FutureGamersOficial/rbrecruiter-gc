<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{

    public $alertType;

    public $extraStyling;

    /**
     * Create a new component instance.
     *
     * @param $alertType
     * @param string $extraStyling
     */
    public function __construct($alertType, $extraStyling = '')
    {
        $this->alertType = $alertType;
        $this->extraStyling = $extraStyling;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
