<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    //
    public function createFollow(User $user)
    {

        if (auth()->user()->id == $user->id) {
            return back()->with('failure', 'You cannot follow yourself.');
        }

        $existCheck = Follow::where([['user_id' , '=', auth()->user()->id], ['followedUser', '=', $user->id]])->count();
        if ($existCheck) {
            return back()->with('failure', 'You are already following this user.');
        }
        $newFollow = new Follow;
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followedUser = $user->id;
        $newFollow->save();

        return back()->with('success', 'You are now following ' . $user->username);

    }
    public function removeFollow(User $user)
    {
        Follow::where([['user_id','=',auth()->user()->id],['followedUser','=',$user->id]])->delete();
        return back()->with('success','User successfully unfollowed.');
    }

}
