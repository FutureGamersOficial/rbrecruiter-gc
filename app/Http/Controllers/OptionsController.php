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

namespace App\Http\Controllers;

use App\Exceptions\InvalidGamePreferenceException;
use App\Exceptions\OptionNotFoundException;
use App\Facades\Options;
use App\Options as Option;
use App\Services\ConfigurationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OptionsController extends Controller
{
    private $configurationService;

    public function __construct(ConfigurationService $configurationService) {

        $this->configurationService = $configurationService;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        // TODO: Replace with settings package
        return view('dashboard.administration.settings')
            ->with([
                'options' => Options::getCategory('notifications'),
                'security' => [ // We could use the method above, but we need to set these names here for greater control in the template. This would nto be feasible for many options, we'd need to use a loop and the category method.
                    'secPolicy' => Options::getOption('pw_security_policy'),
                    'graceperiod' => Options::getOption('graceperiod'),
                    'pwExpiry' => Options::getOption('password_expiry'),
                    'requiresPMC' => Options::getOption('requireGameLicense'),
                    'enforce2fa' => Options::getOption('force2fa')
                ],
                'currentGame' => Options::getOption('currentGame')
            ]);
    }

    public function saveSettings(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {

            if (Auth::user()->can('admin.settings.edit')) {
                $this->configurationService->saveConfiguration($request->all());

                return redirect()
                    ->back()
                    ->with('success', __('Options updated successfully!'));
            }

        } catch (OptionNotFoundException | \Exception $ex) {

            return redirect()
                ->back()
                ->with('error', $ex->getMessage());

        }

        return redirect()
            ->back()
            ->with('error', __('You do not have permission to update this resource.'));
    }

    public function saveGameIntegration(Request $request)
    {
        try {

            $this->configurationService->saveGameIntegration($request->gamePref);
            return redirect()
                ->back()
                ->with('success', __('Game preference updated.'));

        } catch (InvalidGamePreferenceException $ex) {
            return redirect()
                ->back()
                ->with('error', $ex->getMessage());
        }
    }
}
