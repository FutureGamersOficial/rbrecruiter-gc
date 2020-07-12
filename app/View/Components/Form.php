<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Form extends Component
{

    public $formFields;


    public $disableFields = false;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($disableFields = false)
    {
       $this->disableFields = $disableFields;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form');
    }
}
