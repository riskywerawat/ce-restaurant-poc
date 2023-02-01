<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetupUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSetupController extends Controller
{
    public function create(Request $request, $token)
    {
        $user = User::findOrFail($request->key);

        $setup = DB::table('user_setups')
            ->where('token', $token)
            ->where('user_id', $user->id)
            ->first();

        if ($user->password) { // already setup
            return redirect()->route('login')->with('info', 'Account already set up. Please login.');
        }

        if (!$setup) {
            abort(404);
        }

        return view('auth.setup', [
            'request' => $request,
            'user' => $user,
            'setup' => $setup
        ]);
    }

    public function store(SetupUserRequest $request, $token)
    {
        $user = User::findOrFail($request->key);
//        dd($user);
        if (!$user) {
            abort(404);
        }
        if ($user->password) { // already setup
            abort(404);
        }

        DB::table('user_setups')
            ->where('token', $request->token)
            ->where('user_id', $request->key)
            ->delete();

        $user->password = Hash::make($request->password);
        if ($user->isUser()) {
            $user->pin = $request->pin;
        }
        $user->save();

        return redirect()->route('login')->with('info', 'Successfully save your password. Please login.');
    }
}
