<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ChangePasswordRequest;
use App\Http\Requests\Dashboard\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        return view('dashboard.settings.profile', compact('user'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $user->name = $request->name;
        $user->save();

        return redirect()->back()->with('success', 'แก้ไขข้อมูลส่วนบุคคลเรียบร้อยแล้ว');
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'แก้ไขรหัสผ่านเรียบร้อยแล้ว');
    }
}
