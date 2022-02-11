<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public string
        $type,
        $icon,
        $link,
        $target,
        $size,
        $color,
        $disabled,
        $id;

    public function __construct($id, $color, $type = 'button', $disabled = false, $size = '', $target = '', $link = '', $icon = '')
    {
        $this->link = $link;
        $this->disabled = $disabled;
        $this->type = $type;
        $this->target = $target;
        $this->size = $size;
        $this->color = $color;
        $this->id = $id;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
