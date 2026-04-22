<?php

namespace App\Pulse;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Laravel\Pulse\Contracts\ResolvesUsers;

class AnonymousVisitorUsers implements ResolvesUsers
{
    public function key(Authenticatable $user): int|string|null
    {
        return $user->getAuthIdentifier();
    }

    /**
     * @param  Collection<int, int|string|null>  $keys
     */
    public function load(Collection $keys): self
    {
        return $this;
    }

    public function find(int|string|null $key): object
    {
        $short = substr((string) $key, 0, 8);

        return (object) [
            'name' => "Visitor {$short}",
            'extra' => '',
            'avatar' => sprintf(
                'https://gravatar.com/avatar/%s?d=identicon',
                hash('sha256', (string) $key),
            ),
        ];
    }
}
