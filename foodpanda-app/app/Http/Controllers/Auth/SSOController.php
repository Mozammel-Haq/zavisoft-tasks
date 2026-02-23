<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SSOController extends Controller
{

    // Redirect User to ecommerce oAuth page

    public function redirect(){
        $state =Str::random(30);
        session(['sso_state' => $state]);

        $query = http_build_query([
            'client_id' => config('sso.client_id'),
            'redirect_uri'=>config('sso.redirect_uri'),
            'response_type'=>'code',
            'scope'=>'',
            'state'=>$state
        ]);
        return redirect(config('sso.server_url').'/oauth/authorize?'.$query);
    }
    public function callback(Request $request){
        if($request->state !== session('sso_state')){
            Log::warning('SSO State Doesnt Match - Possible CSRF attempt');
            return redirect()->route('login')->withErrors([
                'sso' => 'Invalid SSO State. Please Try Again !'
            ]);
        }
        $tokenResponse =Http::asForm()->post(
            config('sso.server_url') . '/oauth/token',
            [
                'grant_type' => 'authorization_code',
                'client_id' => config('sso.client_id'),
                'client_secret' => config('sso.client_secret'),
                'redirect_uri'=>config('sso.redirect_uri'),
                'code' => $request->code,
            ],
        );
        if($tokenResponse->failed()){
            Log::error('SSO Token Exchange Failed',[
                'status'=>$tokenResponse->status(),
                'response'=> $tokenResponse->body()
            ]);

            return redirect()->route('login')->withErrors([
                'sso' => 'SSO Authenticatication Failed. Please Try Again !'
            ]);
        }

        $aceessToken = $tokenResponse->json('access_token');

        // Passport exposes the authenticated user at /api/user by default;
        // make sure you hit the correct endpoint on the SSO server.  if your
        // provider uses a different URL adjust accordingly.
        $profileUrl = config('sso.server_url').'/api/user';

        $userResponse = Http::withToken($aceessToken)->get($profileUrl);

        if ($userResponse->failed()) {
            Log::error('SSO user fetch failed', [
                'status'   => $userResponse->status(),
                'response' => $userResponse->body(),
                'url'      => $profileUrl,
            ]);

            return redirect()->route('login')->withErrors([
                'sso' => 'Could not retrieve your profile. Please try again.',
            ]);
        }

        $userData = $userResponse->json();

        // guard against invalid/missing data so we don't try to index null
        if (!is_array($userData) || ! isset($userData['id'])) {
            Log::error('SSO user payload invalid', ['payload' => $userData]);

            return redirect()->route('login')->withErrors([
                'sso' => 'Received unexpected data from SSO provider.',
            ]);
        }

        // Find or create user in foodpanda's database
        $user = User::firstOrCreate(
            ['sso_id' => (string) $userData['id']],
            [
                'name'     => $userData['name'],
                'email'    => $userData['email'],
                // Password is random — this user authenticates via SSO only
                'password' => bcrypt(Str::random(16)),
            ]
        );

        // Update name/email in case they changed in ecommerce-app
        $user->update([
            'name'  => $userData['name'],
            'email' => $userData['email'],
        ]);

        Auth::login($user,remember: true);

        $request->session()->regenerate();
         return redirect()->route('dashboard')->with('success', 'You have been automatically logged in via SSO.');

    }


}
