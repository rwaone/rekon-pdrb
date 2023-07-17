<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {

        if (!(Hash::check($request->get('old_password'), auth()->user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Password lama salah");
        }

        if (strcmp($request->get('old_password'), $request->get('password')) == 0) {
            // Current password and new password same
            return redirect()->back()->with("error", "Password baru tidak boleh sama dengan password lama");
        }

        $validatedData = $request->validate([
            'old_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = auth()->user();
        $user->password = Hash::make($validatedData['password']);

        User::where('id', $user->id)->update(['password' => Hash::make($validatedData['password'])]);
        return redirect()->back()->with("success", "Password successfully changed!");
    }
}
