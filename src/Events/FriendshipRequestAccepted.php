<?php

namespace Envant\Friendships\Events;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class FriendshipRequestAccepted
{
    use Dispatchable,
        SerializesModels;

    /** @var \Illuminate\Contracts\Auth\Authenticatable $sender */
    public $sender;

    /** @var \Illuminate\Contracts\Auth\Authenticatable $recipient */
    public $recipient;

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $sender
     * @param \Illuminate\Contracts\Auth\Authenticatable $recipient
     */
    public function __construct(Authenticatable $sender, Authenticatable $recipient)
    {
        $this->sender = $sender;
        $this->recipient = $recipient;
    }
}
