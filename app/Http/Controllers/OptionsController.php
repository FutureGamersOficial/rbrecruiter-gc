<?php

namespace App\Http\Controllers;

use App\Helpers\Options;
use App\Options as Option;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
       if (Auth::user()->hasPermission('admin.settings.edit'))
       {
           foreach($request->all() as $optionName => $option)
           {
               try
               {
                   if (Options::optionExists($option))
                   {
                       Options::changeOption($optionName, $option);
                   }
               }
               catch(\Exception $ex)
               {
                   // Silently ignore, because the only way this would happen is if someone manipulates the page,
                   // and obviously we can't save arbitrary option values even if the user has permission to do so.
                   continue;
               }
           }

           $request->session()->flash('success', 'Settings saved successfully!');
       }
       else
       {
           $request->session()->flash('error', 'You do not have permission to update this resource.');
       }

       return redirect()->back();
   }
}
