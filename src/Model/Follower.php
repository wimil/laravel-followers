<?php
namespace Wimil\Followers\Model;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $table;

    public $timestamps = false;

    protected $fillable = [
        'follower_id',
        'follower_type',
        'followable_id',
        'followable_type',
        'created_at'
    ];

    //modelo que puede seguir
    public function follower()
    {
        return $this->morphTo();
    }

    //modelo que puede ser seguido
    public function followable()
    {
        return $this->morphTo();
    }

    public function getTable()
    {
        if (!$this->table) {
            $this->table = config('followers.table_name', 'followers');
        }
        return parent::getTable();
    }
}
