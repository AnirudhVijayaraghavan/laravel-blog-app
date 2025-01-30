<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{
    //
    public function welcomePage()
    {
        return view('welcome');
    }
    public function HomeGuest()
    {
        return view('homeguest');
    }
    public function AboutPage()
    {
        // return '<h1>About</h1> <a href="/"> Back to Home Page </a>';
        $Name = 'Anirudh';

        return view('single-post', ['name' => $Name]);
    }
    public function register(Request $request)
    {
        $incomingFields = $request->validate(
            [

                'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'password' => ['required', 'min:8', 'confirmed']
            ]

        );
        $user = User::create($incomingFields);
        auth()->login($user);
        return redirect('/')->with('success', 'Thank you for creating an account.');
    }
    public function login(Request $request)
    {
        $outgoingFields = $request->validate(
            [

                'loginusername' => ['required'],
                'loginpassword' => ['required']
            ]

        );
        if (
            auth()->attempt(
                [
                    'username' => $outgoingFields['loginusername'],
                    'password' => $outgoingFields['loginpassword']
                ]
            )
        ) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'You have successfully logged in.');
        } else {
            return redirect('/')->with('failure', 'Incorrect login attempt.');
        }
        //User::create($outgoingFields);
        //return 'hello';
    }
    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'You have successfully logged out.');
    }

    public function ShowCorrectHomePage()
    {
        if (auth()->check()) {
            return view('homepage-feed', ['feedPosts' => auth()->user()->feedPosts()->latest()->paginate(2)]);
        } else {
            return view('homeguest');
        }
    }

    private function renderSharedData($userprofile)
    {
        $currentlyFollowing = 0;
        if (auth()->check()) {
            $currentlyFollowing = Follow::where([['user_id', '=', auth()->user()->id], ['followedUser', '=', $userprofile->id]])->count();
        }
        View::share('sharedData', [
            'username' => $userprofile->username,
            'postCount' => $userprofile->posts()->count(),
            'avatar' => $userprofile->avatar,
            'currentlyFollowing' => $currentlyFollowing,
            'followerCount' => $userprofile->followers()->count(),
            'followingCount' => $userprofile->following()->count()
        ]);
    }

    public function showProfile(User $userprofile)
    {
        $this->renderSharedData($userprofile);

        //return $userprofile->posts()->get();
        return view('profile', [
            'posts' => $userprofile->posts()->latest()->get()
        ]);
    }

    public function showProfileFollowers(User $userprofile)
    {
        $this->renderSharedData($userprofile);

        //return $userprofile->posts()->get();
        return view('profile-followers', [

            'followers' => $userprofile->followers()->latest()->get()

        ]);
    }
    public function showProfileFollowing(User $userprofile)
    {
        $this->renderSharedData($userprofile);

        //return $userprofile->posts()->get();
        return view('profile-following', [
            'following' => $userprofile->following()->latest()->get()
        ]);
    }

    public function showAvatarForm()
    {
        return view('avatar-form');
    }

    public function storeAvatar(Request $request)
    {
        $request->validate(
            [

                'avatar' => 'required|image|max:3000'
            ]

        );
        $user = auth()->user();
        $filename = $user->id . "-" . uniqid() . ".jpg";
        //$request->file('avatar')->store('avatars', 'public');
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file("avatar"));
        $imgData = $image->cover(120, 120)->toJpeg();
        Storage::disk('public')->put('avatars/' . $filename, $imgData);

        $oldAvatar = $user->avatar;

        $user->avatar = $filename;
        $user->save();

        if ($oldAvatar != "/fallback-avatar.jpg") {
            Storage::disk('public')->delete(str_replace("/storage/", "", $oldAvatar));
        }
        return back()->with('success', 'Avatar changed successfully.');
        //return 'hey';
    }
}
