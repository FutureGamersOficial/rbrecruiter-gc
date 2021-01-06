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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * The options class. A simple wrapper around the model. Could be a repository, but we're not using that design pattern just yet
 */
class Options
{

    /**
     * Returns an assortment of settings found in the mentioned category
     * 
     * @param $category The category
     * @return Collection The settings in this category
     */
    public function getCategory(string $category): Collection
    {
        $options = Option::where('option_category', $category)->get();
        if ($options->isEmpty())
        {
           throw new \Exception('There are no options in category ' . $category);
        }
        return $options;
    }


    public function getOption(string $option): string
    {
        $value = Cache::get($option);
        

        if (is_null($value)) {
            Log::debug('Option '.$option.'not found in cache, refreshing from database');
            $value = Option::where('option_name', $option)->first();
            if (is_null($value)) {
                throw new \Exception('This option does not exist.');
            }
            Cache::put($option, $value->option_value);
            Cache::put($option.'_desc', 'Undefined description');

            return $value->option_value;
        }

        return $value;
    }

    // Null categories are settings without categories and will appear ungrouped
    public function setOption(string $option, string $value, string $description, string $category = null)
    {
        Option::create([
            'option_name' => $option,
            'option_value' => $value,
            'friendly_name' => $description,
            'option_category' => $category
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
