<?php

/*
 * Copyright © 2020 Miguel Nogueira
 *
 *   This file is part of Raspberry Staff Manager.
 *
 *     Raspberry Staff Manager is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     Raspberry Staff Manager is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with Raspberry Staff Manager.  If not, see <https://www.gnu.org/licenses/>.
 */

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
