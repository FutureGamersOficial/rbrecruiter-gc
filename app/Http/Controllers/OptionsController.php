<?php

namespace App\Http\Controllers;

use App\Facades\Options;
use App\Options as Option;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        // TODO: Obtain this from the facade
        $options = Option::all();


        return view('dashboard.administration.settings')
            ->with('options', $options);
    }

   public function saveSettings(Request $request)
   {
       if (Auth::user()->can('admin.settings.edit'))
       {
           Log::debug('Updating application options', [
               'ip' => $request->ip(),
               'ua' => $request->userAgent(),
               'username' => Auth::user()->name
           ]);
           foreach($request->all() as $optionName => $option)
           {
               try
               {
                   Log::debug('Going through option ' . $optionName);
                   if (Options::optionExists($optionName))
                   {
                       Log::debug('Option exists, updating to new values', [
                           'opt' => $optionName,
                           'new_value' => $option
                       ]);
                       Options::changeOption($optionName, $option);
                   }
               }
               catch(\Exception $ex)
               {
                   Log::error('Unable to update options!', [
                       'msg' => $ex->getMessage(),
                       'trace' => $ex->getTraceAsString()
                   ]);
                   report($ex);

                   $errorCond = true;
                   $request->session()->flash('error', 'An error occurred while trying to save settings: ' . $ex->getMessage());
               }
           }

           if (!isset($errorCond))
           {
               $request->session()->flash('success', 'Settings saved successfully!');
           }
       }
       else
       {
           $request->session()->flash('error', 'You do not have permission to update this resource.');
       }

       return redirect()->back();
   }
}
