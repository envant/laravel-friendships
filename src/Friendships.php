<?php

namespace Envant\Friendships;

use Illuminate\Contracts\Auth\Authenticatable;

abstract class Friendships
{
    /**
     * Get auth model
     *
     * @return string
     * @throws Exception
     */
    public static function getAuthModelName(): string
    {
        if (config('comments.user_model')) {
            return config('friendships.user_model');
        }

        if (!is_null(config('auth.providers.users.model'))) {
            return config('auth.providers.users.model');
        }

        throw new Exception('Could not determine authenticatable model name.');
    }

    /**
     * Get user instance
     *
     * @param int $userId
     * @return \Illuminate\Contracts\Auth\Authenticatable
     * @throws Exception
     */
    public static function getAuthModel(int $userId): Authenticatable
    {
        $modelName = static::getAuthModelName();
        $user = (new $modelName())->findOrFail($userId);

        return $user;
    }
}
