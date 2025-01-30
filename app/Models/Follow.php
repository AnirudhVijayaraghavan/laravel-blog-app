<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    //
    public function userDoingTheFollowing() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function userBeingFollowed() {
        return $this->belongsTo(User::class, 'followedUser');
    }
}
