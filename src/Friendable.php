<?php

namespace Envant\Friendships;

use Envant\Friendships\Events\FriendshipRequestAccepted;
use Envant\Friendships\Events\FriendshipRequestCreated;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

/** @mixin \Illuminate\Database\Eloquent\Model */
trait Friendable
{
    /*
     |--------------------------------------------------------------------------
     | Relationships
     |--------------------------------------------------------------------------
     */

    /**
     * Friends
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friends(): BelongsToMany
    {
        return $this->incomingRequests()
            ->whereHas('incomingRequests', function (Builder $query) {
                $query->where('sender_id', $this->id);
            });
    }

    /**
     * Followers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers(): BelongsToMany
    {
        return $this->incomingRequests()
            ->whereDoesntHave('incomingRequests', function (Builder $query) {
                $query->where('sender_id', $this->id);
            });
    }

    /**
     * Following
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function following(): BelongsToMany
    {
        return $this->outgoingRequests()
            ->whereDoesntHave('outgoingRequests', function (Builder $query) {
                $query->where('recipient_id', $this->id);
            });
    }

    /**
     * Incoming requests
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function incomingRequests(): BelongsToMany
    {
        return $this->belongsToMany(
            Friendships::getAuthModelName(),
            FriendshipRequest::getModel()->getTable(),
            'recipient_id',
            'sender_id'
        );
    }

    /**
     * Outgoing requests
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function outgoingRequests(): BelongsToMany
    {
        return $this->belongsToMany(
            Friendships::getAuthModelName(),
            FriendshipRequest::getModel()->getTable(),
            'sender_id',
            'recipient_id'
        );
    }

    /*
     |--------------------------------------------------------------------------
     | Methods
     |--------------------------------------------------------------------------
     */

    /**
     * Befriend user
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @return void
     */
    public function befriend(Authenticatable $user): void
    {
        $this->following()->syncWithoutDetaching($user->getKey());

        if ($user->is_friend) {
            event(new FriendshipRequestAccepted($user, $this));
        } else {
            event(new FriendshipRequestCreated($this, $user));
        }
    }

    /**
     * Unfriend user
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @return void
     */
    public function unfriend(Authenticatable $user): void
    {
        $this->following()->detach($user->getKey());
    }

    /*
     |--------------------------------------------------------------------------
     | Accessors
     |--------------------------------------------------------------------------
     */

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getFriendshipStatusAttribute(): ?string
    {
        if ($this->is_friend) {
            return FriendshipStatus::Friends;
        } elseif ($this->is_follower) {
            return FriendshipStatus::Follower;
        } elseif ($this->is_following) {
            return FriendshipStatus::Following;
        }

        return FriendshipStatus::None;
    }

    /**
     * Determine if user is a friend of current user
     *
     * @return bool
     */
    public function getIsFriendAttribute(): bool
    {
        return Auth::check()
            && $this->friends()->where('sender_id', Auth::id())->exists();
    }

    /**
     * Determine if user follows current user
     *
     * @return bool
     */
    public function getIsFollowerAttribute(): bool
    {
        return Auth::check()
            && $this->following()->where('recipient_id', Auth::id())->exists();
    }

    /**
     * Determine if user is followed by current user
     *
     * @return bool
     */
    public function getIsFollowingAttribute(): bool
    {
        return Auth::check()
            && $this->followers()->where('sender_id', Auth::id())->exists();
    }
}
