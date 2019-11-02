<?php

namespace Envant\Friendships;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FriendshipRequest extends Pivot
{
    /** @var array  */
    protected $guarded = [
        'id',
    ];

    /**
     * Override default model name
     *
     * @return string
     */
    public function getTable(): string
    {
        return config('friendships.table');
    }

    /*
     |--------------------------------------------------------------------------
     | Relationships
     |--------------------------------------------------------------------------
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(Friendships::getAuthModelName(), 'sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(Friendships::getAuthModelName(), 'recipient_id');
    }
}
