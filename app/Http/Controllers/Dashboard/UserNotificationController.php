<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ResetPinNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;

class UserNotificationController extends Controller
{
    public function sendResetPin(User $user)
    {
        $this->authorize('manage', User::class);

        // delete old pin reset (if any)
        DB::table('pin_resets')->where('user_id', $user->id)->delete();

        $token = $this->createResetPinToken($user);
        $user->notify(new ResetPinNotification($user, $token));

        return redirect()->back()->with('success', 'Successfully send PIN reset email.');
    }

    protected function createResetPinToken(User $user)
    {
        $key = config('app.key');

        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        $token = hash_hmac('sha256', Str::random(40), $key);

        DB::table('pin_resets')->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => new Carbon()
        ]);

        return $token;
    }

    public function sendResetPassword(Request $request, User $user)
    {
        $broker = Password::broker(config('fortify.passwords'));
        $broker->sendResetLink(['email' => $user->email]);

        return redirect()->back()->with('success', 'Successfully send password reset email.');
    }
}
