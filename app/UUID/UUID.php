<?php

/*
 * Copyright © 2020 Miguel Nogueira
 *
 *   This file is part of Raspberry Staff Manager.
 *
 *     Raspberry Staff Manager is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     Raspberry Staff Manager is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with Raspberry Staff Manager.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\UUID;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UUID
{
    // Caching would not be needed here since this method won't be used in pages that loop over a collection of usernames.
    public function toUUID($username)
    {
        if (is_null($username)) {
            throw new \LogicException('Argument username for '.__METHOD__.' cannot be null!');
        }

        $response = json_decode(Http::post(trim(config('general.urls.mojang.api')).'/profiles/minecraft', [
            $username,
        ])->body(), true);

        if (isset($response[0])) {
            return $response[0]['id'];
        }

        throw new \InvalidArgumentException('You must supply a valid, premium Minecraft account to sign up.');
    }

    // Note: Caching could simply be assigning the username to it's UUID, however, to make this work, we'd need to loop over all cache items, which would be slighly ineffective
    public function toUsername($uuid)
    {
        if (is_null($uuid)) {
            throw new \LogicException('Argument uuid for '.__METHOD__.' cannot be null!');
        }

        $shortUUID = substr($uuid, 0, 8);
        $username = Cache::remember('uuid_'.$shortUUID, now()->addDays(30), function () use ($shortUUID, $uuid) {
            $response = json_decode(Http::get(trim(config('general.urls.mojang.session')).'/session/minecraft/profile/'.$uuid)->body(), true);

            Log::debug('Caching '.$shortUUID.'for thirty days');

            return $response['name'];
        });

        return $username;
    }
}
