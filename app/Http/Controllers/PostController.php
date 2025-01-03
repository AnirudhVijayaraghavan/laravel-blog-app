<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function showCreateForm()
    {
        return view('create-post');
    }
    public function storeNewPost(Request $request)
    {

        $incomingFields = $request->validate(
            [

                'title' => ['required'],
                'body' => ['required']
            ]

        );
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        return redirect("/post/{$newPost->id}")->with('success', 'New post successfully created.');


        //return view('create-post');
    }
    public function viewSinglePost(Post $postID)
    {

        $ourHTML = Str::markdown($postID->body);
        $postID['body'] = $ourHTML;
        return view('single-post', ['postID' => $postID]);
    }

    public function delete(Post $postID)
    {
        if (auth()->user()->cannot('delete', $postID)) {
            return 'Cannot';
        }
        $postID->delete();
        return redirect('/profile/' . auth()->user()->username)->with('success', 'Post successfully deleted.');
    }

}
