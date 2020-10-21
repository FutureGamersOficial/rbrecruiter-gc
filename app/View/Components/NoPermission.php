<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NoPermission extends Component
{
    public $type;

    public $inDashboard;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $inDashboard = true)
    {
      $this->type = $type;

      $this->inDashboard = $inDashboard;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.no-permission');
    }
}
