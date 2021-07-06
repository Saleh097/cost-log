<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = false;
    public function admin(){
        return $this->belongsTo(User::class);
    }
    public function members(){
        return $this->belongsToMany(User::class, 'user_group_pivot');
    }

    public function waitingJoiners(){
        return $this->belongsToMany(User::class, 'join_requests');
    }
}
