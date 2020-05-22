<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $id;


    public $cardTitle;



    public $footerStyle;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $cardTitle, $footerStyle)
    {
        $this->cardTitle = $cardTitle;
        $this->id = $id;
        $this->footerStyle = $footerStyle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.card');
    }
}
