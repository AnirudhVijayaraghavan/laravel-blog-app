<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            return view('homepage-feed');
        } else {
            return view('homeguest');
        }
    }

    public function showProfile(User $userprofile)
    {
        //return $userprofile->posts()->get();
        return view('profile', ['username' => $userprofile->username, 'posts' => $userprofile->posts()->latest()->get(), 'postCount' => $userprofile->posts()->count()]);
    }
}
