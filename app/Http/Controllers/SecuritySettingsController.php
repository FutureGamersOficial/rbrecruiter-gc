<?php

namespace App\Http\Controllers;

use App\Facades\Options;
use App\Http\Requests\SaveSecuritySettings;
use App\Services\SecuritySettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function PHPSTORM_META\map;

class SecuritySettingsController extends Controller
{
    private $securityService;

    public function __construct(SecuritySettingsService $securityService) {
        $this->securityService = $securityService;
    }

    public function save(SaveSecuritySettings $request)
    {
        $this->securityService->save($request->secPolicy, [
           'graceperiod' => $request->graceperiod,
           'pwExpiry' => $request->pwExpiry,
           'enforce2fa' => $request->enforce2fa,
           'requirePMC' => $request->requirePMC
        ]);

        return redirect()
            ->back()
            ->with('success', __('Settings saved.'));

    }
}
