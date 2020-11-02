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

namespace App\Helpers;

use App\Options as Option;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Options
{
    public function getOption(string $option): string
    {
        $value = Cache::get($option);

        if (is_null($value)) {
            Log::debug('Option '.$option.'not found in cache, refreshing from database');
            $value = Option::where('option_name', $option)->first();
            if (is_null($value)) {
                throw new \Exception('This option does not exist.');
            }
            Cache::put($option, $value);
            Cache::put($option.'_desc', 'Undefined description');
        }

        return $value->option_value;
    }

    public function setOption(string $option, string $value, string $description)
    {
        Option::create([
            'option_name' => $option,
            'option_value' => $value,
            'friendly_name' => $description,
        ]);

        Cache::put($option, $value, now()->addDay());
        Cache::put($option.'_desc', $description, now()->addDay());
    }

    public function pullOption($option): array
    {
        $oldOption = Option::where('option_name', $option)->first();
        Option::find($oldOption->id)->delete();

        // putMany is overkill here
        return [
            Cache::pull($option),
            Cache::pull($option.'_desc'),
        ];
    }

    public function changeOption($option, $newValue)
    {
        $dbOption = Option::where('option_name', $option);

        if ($dbOption->first()) {
            $dbOptionInstance = Option::find($dbOption->first()->id);
            Cache::forget($option);

            Log::debug('Changing db configuration option', [
                'old_value' => $dbOptionInstance->option_value,
                'new_value' => $newValue,
            ]);

            $dbOptionInstance->option_value = $newValue;
            $dbOptionInstance->save();

            Log::debug('New db configuration option saved',
            [
                'option' => $dbOptionInstance->option_value,
            ]);

            Cache::put('option_name', $newValue, now()->addDay());
        } else {
            throw new \Exception('This option does not exist.');
        }
    }

    public function optionExists(string $option): bool
    {
        $dbOption = Option::where('option_name', $option)->first();
        $locallyCachedOption = Cache::get($option);

        return ! is_null($dbOption) || ! is_null($locallyCachedOption);
    }
}
