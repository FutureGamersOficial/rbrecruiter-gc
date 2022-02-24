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

class Alert extends Component
{
    public
        $alertType,
        $extraStyling,
        $title,
        $icon;

    /**
     * Create a new component instance.
     *
     * @param string $alertType The color the alert should have.
     * @param string $title The alert's title
     * @param string $icon The alert's icon, placed before the title
     * @param string $extraStyling Any extra CSS classes to add
     */
    public function __construct(string $alertType, string $title = '', string $icon = '', string $extraStyling = '')
    {
        $this->alertType = $alertType;
        $this->extraStyling = $extraStyling;
        $this->icon = $icon;
        $this->title = $title;
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
