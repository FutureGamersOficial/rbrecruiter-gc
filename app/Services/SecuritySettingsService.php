<?php


namespace App\Services;


use App\Facades\Options;
use Illuminate\Support\Facades\Log;

class SecuritySettingsService
{

    /**
     * Saves the app security settings.
     *
     * @param $policy
     * @param array $options
     * @return bool
     */
    public function save($policy, $options = []) {

        $validPolicies = [
            'off',
            'low',
            'medium',
            'high'
        ];

        if (in_array($policy, $validPolicies))
        {
            Options::changeOption('pw_security_policy', $policy);

            Log::debug('[Options] Changing option pw_security_policy', [
                'new_value' => $policy
            ]);
        }
        else
        {
            Log::debug('[WARN] Ignoring bogus policy', [
                'avaliable' => $validPolicies,
                'given' => $policy
            ]);
        }

        Options::changeOption('graceperiod', $options['graceperiod']);
        Options::changeOption('password_expiry', $options['pwexpiry']);
        Options::changeOption('force2fa', $options['enforce2fa']);
        Options::changeOption('requireGameLicense', $options['requirePMC']);

        return true;

    }

}
