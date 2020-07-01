<?php
namespace Wimil\Followers\Traits;

use Wimil\Followers\Facades\Follow;
/**
 * modelo que puede seguir
 */
trait CanFollow
{
    //relacion con el modelo que puede ser seguido
    public function followables()
    {
        return $this->morphMany(config('followers.model'), 'follower');
    }

    public function follow($followable)
    {
        return Follow::attach($this, $followable);
    }

    public function unfollow($followable)
    {
        return Follow::detach($this, $followable);
    }

    public function toggleFollow($followable)
    {
        return Follow::toggle($this, $followable);
    }

    public function isFollowing($followable)
    {
        return Follow::exists($this, $followable);
    }
}
