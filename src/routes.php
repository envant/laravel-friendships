<?php

Route::prefix(config('friendships.routes.prefix'))
    ->middleware(config('friendships.routes.middleware'))
    ->group(function () {
        Route::get('friends', config('friendships.routes.controller') . '@friends');
        Route::get('following', config('friendships.routes.controller') . '@following');
        Route::get('followers', config('friendships.routes.controller') . '@followers');
        Route::post('users/{user}/befriend', config('friendships.routes.controller') . '@befriend');
        Route::post('users/{user}/unfriend', config('friendships.routes.controller') . '@unfriend');
    });
