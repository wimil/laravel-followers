<?php
namespace Wimil\Followers\Traits;

use Wimil\Followers\Traits\CanBeFollowed;
use Wimil\Followers\Traits\CanFollow;

/**
 * Can Follow and Can be followed
 */

trait Followable
{
    use CanFollow, CanBeFollowed;
}
