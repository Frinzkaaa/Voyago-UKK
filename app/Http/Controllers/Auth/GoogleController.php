<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $googleUser->getId())->orWhere('email', $googleUser->getEmail())->first();

            if($finduser){
                // Update google_id if not exists (case user registered manually before)
                if (!$finduser->google_id) {
                    $finduser->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar()
                    ]);
                }
                
                Auth::login($finduser);
                return redirect()->intended('/');
            }else{
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id'=> $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => encrypt('my-google-auth-pass'), // Dummy password
                    'role' => UserRole::USER,
                    'status' => UserStatus::ACTIVE,
                ]);

                Auth::login($newUser);
                return redirect()->intended('/');
            }
        } catch (Exception $e) {
            return redirect('login')->with('error', 'Gagal masuk dengan Google: ' . $e->getMessage());
        }
    }
}
