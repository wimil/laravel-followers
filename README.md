# Laravel Followers

follower system for laravel, one model can follow another model.

## Installation

### Required

- PHP 7.0 +
- Laravel 5.5 +

You can install the package using composer

```sh
$ composer require wimil/laravel-followers
```

Then add the service provider to `config/app.php`

```php
Wimil\Followers\Provider::class
```

Publish the migrations file:

```sh
$ php artisan vendor:publish --provider="Wimil\Followers\Provider" --tag="migrations"
```

As optional if you want to modify the default configuration, you can publish the configuration file:
 
```sh
$ php artisan vendor:publish --provider="Wimil\Followers\Provider" --tag="config"
```

And create tables:

```php
$ php artisan migrate
```


Finally, add the characteristic function in the model that can be followed and can also be followed:

```php
use Wimil\Followers\Traits\Followable;

class User extends Model
{
    use Followable;
}
```
**Example**
```php
$bob = User::find(1);
$alin = User::find(2);

$bob->follow($alin);
$alin->follow($bob);
$bob->follow([2, 'App\User']);
$alin->follow([1, 'App\User']);

$bob->toggleFollow($alin);
$alis->toggleFollow($bob);
$bob->toggleFollow([2, 'App\User']);
$alin->toggleFollow([1, 'App\User']);

```


## Usage

### Can Follow

```php
use Wimil\Follow\Traits\CanFollow;

class User extends Model
{
    use CanFollow;
}
```

**Example**
All available APIs are listed below.
```php
$user = User::find(1);
$page = Page::find(1);

$user->follow($page);
$user->toggleFollow($page);
$user->unfollow($page);
$user->isFollowing($page);
```



### Can Be Followed

```php
use Wimil\Follow\Traits\CanBeFollowed;

class Page extends Model
{
    use CanBeFollowed;
}
```

**Example**
All available APIs are listed below.
```php
$user = User::find(1);
$page = Page::find(1);

$page->addFollower($user);
$page->deleteFollower($user);
$page->toggleFollower($user);
$page->isFollowedBy($user);
```

**If you want to have your own Follower Model create a new one and extend my Follower model.**

```php
use Wimil\Follow\Model\FollowModel as BaseFollower;

class Follower extends BaseFollower
{
    // ...
}
```
and dont forget to update the model name in the config/followers.php file.

### Facade
**you can also use the facade alias, you must include the facade alias in your config/app.php**
```php
'Follow' => Wimil\Followers\Facades\Follow::class;
```
**Usage**
```php
$bob = User::find(1);
$alin = User::find(2);

Follow::attach($bob, $alin);
Follow::attach($alin, $bob);
Follow::attach([1, 'App\User'], [2, 'App\User']);
Follow::attach([2, 'App\User'], [1, 'App\User']);

Follow::detach($bob, $alin);
Follow::toggle($bob, $alin);
Follow::exists($bob, $alin);
```


## License

MIT

created by wimil