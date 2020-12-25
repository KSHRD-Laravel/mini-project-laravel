<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Services\SocialFacebookAccountService;

class SocialAuthFacebookController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(SocialFacebookAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->stateless()->user());
        auth()->login($user);
        return redirect()->to('/');
    }
}
