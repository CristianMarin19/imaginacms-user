<?php

namespace Modules\User\Traits;

use Modules\User\Entities\UserInterface;
use Modules\User\Repositories\UserTokenRepository;

trait CanFindUserWithBearerToken
{
    public function findUserWithBearerToken(string $token): ?UserInterface
    {
        $token = app(UserTokenRepository::class)->findByAttributes(['access_token' => $this->parseToken($token)]);

        if ($token === null) {
            return null;
        }

        return $token->user;
    }

    private function parseToken($token)
    {
        return str_replace('Bearer ', '', $token);
    }
}
