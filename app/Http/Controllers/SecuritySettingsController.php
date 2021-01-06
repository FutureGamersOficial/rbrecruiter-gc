<?php

namespace App\Http\Controllers;

use App\Facades\Options;
use App\Http\Requests\SaveSecuritySettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function PHPSTORM_META\map;

class SecuritySettingsController extends Controller
{
    public function save(SaveSecuritySettings $request)
    {
        $validPolicies = [
            'off',
            'low',
            'medium',
            'high'
        ];

        if (in_array($request->secPolicy, $validPolicies))
        {
            Options::changeOption('pw_security_policy', $request->secPolicy);

            Log::debug('[Options] Changing option pw_security_policy', [
                'new_value' => $request->secPolicy
            ]);
        }
        else
        {
            Log::debug('[WARN] Ignoring bogus policy', [
                'avaliable' => $validPolicies,
                'given' >= $request->secPolicy
            ]);
        }

        Options::changeOption('graceperiod', $request->graceperiod);
        Options::changeOption('password_expiry', $request->pwExpiry);
        Options::changeOption('force2fa', $request->enforce2fa);
        Options::changeOption('requireGameLicense', $request->requirePMC);

        $request->session()->flash('success', 'Settings saved successfully.');
        return redirect()->back();

    }
}
