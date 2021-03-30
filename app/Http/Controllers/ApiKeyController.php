<?php

namespace App\Http\Controllers;

use App\ApiKey;
use App\Http\Requests\CreateApiKeyRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('dashboard.user.api.index')
            ->with('keys', Auth::user()->keys);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(CreateApiKeyRequest $request)
    {
        $discriminator = "#" . bin2hex(openssl_random_pseudo_bytes(7));
        $secret = bin2hex(openssl_random_pseudo_bytes(32));

        $key = ApiKey::create([
            'name' => $request->keyName,
            'discriminator' => $discriminator,
            'secret' => Hash::make($secret),
            'status' => 'active',
            'owner_user_id' => Auth::user()->id
        ]);

        if ($key)
        {
            $request->session()->flash('success', 'Key successfully registered!');
            $request->session()->flash('finalKey', $discriminator . '.' . $secret);

            return redirect()
                ->back();
        }

        return redirect()
            ->back()
            ->with('error', 'An error occurred whilst trying to create an API key.');
    }


   public function revokeKey(Request $request, ApiKey $key)
   {
       if (Auth::user()->is($key->user) || Auth::user()->hasRole('admin'))
       {
           if ($key->status == 'active')
           {
               $key->status = 'disabled';
               $key->save();
           }
           else
           {
               return redirect()
                   ->back()
                   ->with('error', 'Key already revoked.');
           }

           return redirect()
               ->back()
               ->with('success', 'Key revoked. Apps using this key will stop working.');
       }

       return redirect()
           ->back()
           ->with('error', 'You do not have permission to modify this key.');
   }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $key = ApiKey::findOrFail($id);

        if (Auth::user()->is($key->user) || Auth::user()->hasRole('admin'))
        {
            $key->delete();

            return redirect()
                ->back()
                ->with('success', 'Key deleted successfully. Apps using this key will stop working.');
        }

        return redirect()
            ->back()
            ->with('error', 'You do not have permission to modify this key.');
    }
}
