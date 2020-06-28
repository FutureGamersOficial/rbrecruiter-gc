<?php



namespace App\UUID;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UUID
{

    // Caching would not be needed here since this method won't be used in pages that loop over a collection of usernames.
    public function toUUID($username)
    {
        if (is_null($username))
        {
            throw new \LogicException('Argument username for ' . __METHOD__ . ' cannot be null!');
        }

        $response = json_decode(Http::post(trim(config('general.urls.mojang.api')) . '/profiles/minecraft', [
            $username
        ])->body(), true);

        if (isset($response[0]))
        {
          return $response[0]['id'];

        }

        throw new \InvalidArgumentException("You must supply a valid, premium Minecraft account to sign up.");
    }

    // Note: Caching could simply be assigning the username to it's UUID, however, to make this work, we'd need to loop over all cache items, which would be slighly ineffective
    public function toUsername($uuid)
    {

        if (is_null($uuid))
        {
            throw new \LogicException('Argument uuid for ' . __METHOD__ . ' cannot be null!');
        }

       $shortUUID = substr($uuid, 0, 8);
       $username = Cache::remember('uuid_' . $shortUUID, now()->addDays(30), function() use ($shortUUID, $uuid) {

            $response = json_decode(Http::get(trim(config('general.urls.mojang.session')) . '/session/minecraft/profile/' . $uuid)->body(), true);

            Log::debug('Caching ' . $shortUUID . 'for thirty days');
            return $response['name'];

       });

       return $username;

    }


}
