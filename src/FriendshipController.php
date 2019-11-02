<?php

namespace Envant\Friendships;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;

class FriendshipController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function friends(Request $request): JsonResource
    {
        $items = $request->user()
            ->friends()
            ->paginate();

        return SampleResource::collection($items);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function following(Request $request): JsonResource
    {
        $items = $request->user()
            ->following()
            ->paginate();

        return SampleResource::collection($items);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function followers(Request $request): JsonResource
    {
        $items = $request->user()
            ->followers()
            ->paginate();

        return SampleResource::collection($items);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param mixed $userId
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function befriend(Request $request, $userId): JsonResource
    {
        $user = Friendships::getAuthModel($userId);
        $request->user()->befriend($user);

        return new SampleResource($user);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param mixed $userId
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function unfriend(Request $request, $userId): JsonResource
    {
        $user = Friendships::getAuthModel($userId);
        $request->user()->unfriend($user);

        return new SampleResource($user);
    }
}
