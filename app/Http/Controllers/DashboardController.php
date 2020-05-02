<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{

    public function index()
    {
        // TODO: Switch status checking to provider, share with all views

        // Mojang status for informational purposes
        if (!Cache::has('mojang_status'))
        {
            $mcstatus = Http::get('https://status.mojang.com/check');
            Cache::put('mojang_status', base64_encode($mcstatus->body()), now()->addMinutes(60));
        }

        return view('dashboard.dashboard')
            ->with('mcstatus', json_decode(base64_decode(Cache::get('mojang_status')), true));
    }

}
