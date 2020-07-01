<?php
namespace Wimil\Followers\Helpers;

use Illuminate\Database\Eloquent\Model;
use Wimil\Followers\Exceptions\AlreadyFollowingException;
//use Wimil\Followers\Exceptions\CannotBeFollowedException;
use Wimil\Followers\Exceptions\FollowerNotFoundException;

class Follow
{
    public function attach($follower, $followable)
    {
        $follower = $this->validate($follower);
        $followable = $this->validate($followable);
        if (!is_null($follower) && !is_null($followable)) {
            try {
                return $this->model()::create([
                    'follower_type' => $follower['type'],
                    'follower_id' => $follower['id'],
                    'followable_type' => $followable['type'],
                    'followable_id' => $followable['id'],
                    'created_at' => now(),
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                throw new AlreadyFollowingException($follower['type'] . '::' . $follower['id'] . ' is already following ' . $followable['type'] . '::' . $followable['id']);
            }
        }

    }

    public function detach($follower, $followable)
    {
        $follower = $this->validate($follower);
        $followable = $this->validate($followable);

        $status = (bool) $this->whereFollow($follower, $followable)
            ->delete();

        if ($status) {
            return true;
        }

        throw new FollowerNotFoundException($follower['type'] . '::' . $follower['id'] . ' is not following ' . $followable['type'] . '::' . $followable['id']);
    }

    public function toggle($follower, $followable)
    {
        //$follower = $this->validate($follower);
        //$followable = $this->validate($followable);

        if ($this->exists($follower, $followable)) {
            $this->detach($follower, $followable);
            return false;
        } else {
            $this->attach($follower, $followable);
            return true;
        }
    }

    public function exists($follower, $followable)
    {
        $follower = $this->validate($follower);
        $followable = $this->validate($followable);

        $exists = $this->whereFollow($follower, $followable)
            ->exists();

        return (bool) $exists;
    }

    private function whereFollow($follower, $followable)
    {
        //$follower = $this->validate($follower);
        //$followable = $this->validate($followable);

        return $this->model()::where('follower_id', $follower['id'])
            ->where('follower_type', $follower['type'])
            ->where('followable_id', $followable['id'])
            ->where('followable_type', $followable['type']);
    }

    private function validate($_this)
    {
        //varificamos si es un modelo
        if ($_this instanceof Model) {
            return [
                'type' => get_class($_this),
                'id' => $_this->id,
            ];
        } elseif (is_array($_this)) {
            return [
                'type' => $_this[1],
                'id' => $_this[0],
            ];
        } else {
            return null;
        }
    }

    private function model()
    {
        return config('followers.model');
    }
}
