<?php

namespace App\Traits;

use Illuminate\Http\RedirectResponse;

trait DisablesFeatures
{

    /**
     * Checks if demo mode is active. If so, it stops any more logic from running.
     *
     * @return RedirectResponse|null
     */
    protected function disable(): RedirectResponse|null
    {
        if (config('demo.is_enabled')) {
            return redirect()
                ->back()
                ->with('error', __('This feature is disabled'));
        }
        return null;
    }

}
