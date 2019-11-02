<?php

return [
    'table' => 'friendships',
    'moderation' => false,
    'model' => \Envant\Friendships\FriendshipRequest::class,
    'user_model' => null,
    'routes' => [
        'enabled' => true,
        'controller' => \Envant\Friendships\FriendshipController::class,
        'middleware' => [
            'api', 'auth:api'
        ],
        'prefix' => 'api',
    ],
];
