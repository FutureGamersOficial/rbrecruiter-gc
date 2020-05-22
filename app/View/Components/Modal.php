<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $id;


    public $modalLabel;


    public $modalTitle;


    public $includeCloseButton;

    /**
     * Create a new component instance.
     *
     * @param $id
     * @param $modalLabel
     * @param $modalTitle
     * @param $includeCloseButton
     */
    public function __construct($id, $modalLabel, $modalTitle, $includeCloseButton)
    {
        $this->id = $id;
        $this->modalLabel = $modalLabel;
        $this->modalTitle = $modalTitle;
        $this->includeCloseButton = $includeCloseButton;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
