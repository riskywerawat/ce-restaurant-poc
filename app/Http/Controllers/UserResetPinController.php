<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPinRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class UserResetPinController extends Controller
{
    public function reset(Request $request, $token)
    {
        $user = $request->user();

        $reset = DB::table('pin_resets')
            ->where('token', $token)
            ->where('user_id', $user->id)
            ->first();

        if (!$reset) {
            abort(404);
        }

        return view('auth.reset-pin', [
            'request' => $request,
            'user' => $user,
            'reset' => $reset
        ]);
    }

    public function doReset(ResetPinRequest $request)
    {
        $user = $request->user();

        $reset = DB::table('pin_resets')
            ->where('token', $request->token)
            ->where('user_id', $user->id)
            ->first();

        if (!$reset) {
            abort(404);
        }

        DB::table('pin_resets')
            ->where('token', $request->token)
            ->where('user_id', $user->id)
            ->delete();

        $user->pin = $request->pin;
        $user->save();

        return redirect()->route('market.index')->with('success', 'Successfully reset pin');
    }
}
