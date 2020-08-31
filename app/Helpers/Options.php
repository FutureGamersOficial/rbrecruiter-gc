<?php


namespace App\Helpers;

use App\Options as Option;
use Illuminate\Support\Facades\Cache;

class Options
{

    public function getOption(string $option): string
    {
        $value = Cache::get($option);

        if (is_null($value))
        {
            $value = Option::where('option_name', $option)->first();
            if (is_null($value))
                throw new \Exception('This option does not exist.');

            Cache::put($option, $value);
            Cache::put($option . '_desc', 'Undefined description');
        }

        return $value->option_value;
    }

    public function setOption(string $option, string $value, string $description)
    {
       Option::create([
           'option_name' => $option,
           'option_value' => $value,
           'friendly_name' => $description
       ]);

       Cache::put($option, $value, now()->addDay());
       Cache::put($option . '_desc', $description, now()->addDay());
    }

    public function pullOption($option): array
    {
        $oldOption = Option::where('option_name', $option)->first();
        Option::find($oldOption->id)->delete();

        // putMany is overkill here
        return [
            Cache::pull($option),
            Cache::pull($option . '_desc')
        ];
    }

    public function changeOption($option, $newValue)
    {
        $dbOption = Option::where('option_name', $option);

        if ($dbOption->first())
        {
            $dbOptionInstance = Option::find($dbOption->first()->id);
            Cache::forget($option);


            $dbOptionInstance->option_value = $newValue;
            $dbOptionInstance->save();

            Cache::put('option_name', $newValue, now()->addDay());
        }
        else
        {
            throw new \Exception('This option does not exist.');
        }
    }


    public function optionExists(string $option): bool
    {
        $dbOption = Option::where('option_name', $option)->first();
        $locallyCachedOption = Cache::get($option);

        return !is_null($dbOption) || !is_null($locallyCachedOption);
    }

}
