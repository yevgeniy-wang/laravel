<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController
{

    public function login()
    {
        $gitHubLink = 'https://github.com/login/oauth/authorize';
        $parameters = [
            'client_id'    => env('OAUTH_GITHUB_CLIENT_ID'),
            'redirect_uri' => env('OAUTH_GITHUB_REDIRECT_URI'),
            'scope'        => 'user,user:email',
        ];

        $gitHubLink .= '?'.http_build_query($parameters);

        $yahooLink = 'https://api.login.yahoo.com/oauth2/request_auth';
        $parameters = [
            'client_id'     => env('OAUTH_YAHOO_CLIENT_ID'),
            'redirect_uri'  => env('OAUTH_YAHOO_REDIRECT_URI'),
            'response_type' => 'code',
        ];

        $yahooLink .= '?'.http_build_query($parameters);

        return view("pages.login", compact('gitHubLink', 'yahooLink'));
    }

    public function handleLogin(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        if (Auth::attempt($data)) {
            if (Hash::needsRehash(User::find(Auth::id())->password)) {
                $user = User::find(Auth::id());
                $user->password
                    = Hash::make($request->only('password')['password']);
                $user->save();
            }

            return redirect()->route('admin');
        }

        return back()->withErrors([
            'password' => 'Incorrect email or password',
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');

    }
}
