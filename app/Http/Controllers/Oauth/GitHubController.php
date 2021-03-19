<?php


namespace App\Http\Controllers\Oauth;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class GitHubController
{
    public function __invoke()
    {
        $link = 'https://github.com/login/oauth/access_token';

        $parameters = [
            'client_id' => env('OAUTH_GITHUB_CLIENT_ID'),
            'client_secret' => env('OAUTH_GITHUB_CLIENT_SECRET'),
            'code' => request()->get('code'),
            'redirect_uri' => env('OAUTH_GITHUB_REDIRECT_URI'),
        ];

        $link .= '?'.http_build_query($parameters);

        $response = Http::post($link);


        if (!$response->ok()) {
            return redirect()->route('login')
                ->with('error', 'Something went wong, please try again');
        }

        $data = [];
        parse_str($response->body(), $data);

        $response = Http::withHeaders([
            'Authorization' => 'token '.$data['access_token'],
        ])
            ->get('https://api.github.com/user');

        $userInfo = $response->json();

        $response = Http::withHeaders([
            'Authorization' => 'token '.$data['access_token'],
        ])
            ->get('https://api.github.com/user/emails');

        $userEmails = $response->json();
        $email = $userEmails['0']['email'];

        if (null === ($user = User::where('email', $email)->first())){
            $data = [
                'name' => $userInfo['name'],
                'email' => $email,
                'password' => Hash::make($userInfo['node_id']),
            ];

            $user = User::create($data);
        }

        Auth::login($user);

        return redirect()->route('home')->with('success', 'You have successfully logged in.');

    }
}

