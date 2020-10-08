<?php

namespace App\Traits;

use Illuminate\Support\Facades\Hash;

trait HandlesAccountTokens
{


    public function generateAccountTokens()
    {
        $deleteToken = bin2hex(openssl_random_pseudo_bytes(32));
        $cancelToken = bin2hex(openssl_random_pseudo_bytes(32));

        $tokens = [

            'delete' => Hash::make($deleteToken),
            'cancel' => Hash::make($cancelToken)

        ];

        $this->account_tokens = json_encode($tokens);
        $this->save();

        return [

            'delete' => $deleteToken,
            'cancel' => $cancelToken
        ];

    }

    public function verifyAccountToken(string $token, string $type): bool
    {
        $tokens = json_decode($this->account_tokens);

        if ($type == 'deleteToken')
        {
            return Hash::check($token, $tokens->delete);
        }
        elseif ($type == 'cancelToken')
        {
            return Hash::check($token, $tokens->cancel);
        }     

        return false;
    }   


}