<?php


namespace App\Services;


use App\Exceptions\InvalidGamePreferenceException;
use App\Exceptions\OptionNotFoundException;
use App\Facades\Options;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ConfigurationService
{

    /**
     * @throws OptionNotFoundException|\Exception
     *
     */
    public function saveConfiguration($configuration) {

        foreach ($configuration as $optionName => $option) {
            try {

                Log::debug('Going through option '.$optionName);
                if (Options::optionExists($optionName)) {
                    Log::debug('Option exists, updating to new values', [
                        'opt' => $optionName,
                        'new_value' => $option,
                    ]);
                    Options::changeOption($optionName, $option);
                }

            } catch (\Exception $ex) {

                Log::error('Unable to update options!', [
                    'msg' => $ex->getMessage(),
                    'trace' => $ex->getTraceAsString(),
                ]);

                // Let service caller handle this without failing here
                throw $ex;
            }
        }
    }

    /**
     * Saves the chosen game integration
     *
     * @throws InvalidGamePreferenceException
     * @returns bool
     */
    public function saveGameIntegration($gamePreference): bool
    {

        // TODO: Find solution to dynamically support games

        $supportedGames = [
            'RUST',
            'MINECRAFT',
            'SE',
            'GMOD'
        ];

        if (!is_null($gamePreference) && in_array($gamePreference, $supportedGames))
        {
            Options::changeOption('currentGame', $gamePreference);
            return true;
        }

        throw new InvalidGamePreferenceException("Unsupported game " . $gamePreference);
    }

}
