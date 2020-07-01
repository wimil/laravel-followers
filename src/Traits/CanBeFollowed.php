<?php
namespace Wimil\Followers\Traits;

use Wimil\Followers\Facades\Follow;
/**
 * modelo que puede ser seguido
 */
trait CanBeFollowed
{
    //relacion con el modelo que puede seguir
    public function followers()
    {
        return $this->morphMany(config('followers.model'), 'followable');
    }

    public function addFollower($follower)
    {
        return Follow::attach($follower, $this);
    }

    public function deleteFollower($follower)
    {
        return Follow::detach($follower, $this);
    }

    public function toggleFollower($follower)
    {
        return Follow::toggle($follower, $this);
    }

    public function isFollowedBy($follower)
    {
        return Follow::exists($follower, $this);
    }
}
