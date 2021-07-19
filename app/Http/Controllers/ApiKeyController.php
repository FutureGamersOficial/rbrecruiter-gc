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

    public function index()
    {
        $this->authorize('viewAny', ApiKey::class);

        return view('dashboard.administration.keys')
            ->with('keys', ApiKey::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(CreateApiKeyRequest $request)
    {
        $this->authorize('create', ApiKey::class);

        $discriminator = "#" . bin2hex(random_bytes(7));
        $secret = bin2hex(random_bytes(32));

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
       $this->authorize('update', $key);

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $key = ApiKey::findOrFail($id);
        $this->authorize('delete', $key);

        $key->delete();

        return redirect()
            ->back()
            ->with('success', 'Key deleted successfully. Apps using this key will stop working.');

    }
}
