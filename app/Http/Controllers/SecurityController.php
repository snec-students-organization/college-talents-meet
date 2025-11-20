<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SecurityController extends Controller
{
    public function check()
    {
        $exists = DB::table('security')->first();

        if (!$exists) {
            return view('security.set_password');
        }

        return view('security.login');
    }

    public function storePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:4'
        ]);

        DB::table('security')->insert([
            'password' => $request->password,
            'created_at' => now(),
        ]);

        Session::put('authenticated', true);

        return redirect('/');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        $saved = DB::table('security')->first();

        if ($saved && $saved->password === $request->password) {
            Session::put('authenticated', true);
            return redirect('/');
        }

        return back()->withErrors(['password' => 'Incorrect password']);
    }
    public function changePasswordForm()
{
    if (!session('authenticated')) {
        return redirect('/secure');
    }

    return view('security.change_password');
}

public function changePassword(Request $request)
{
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:4',
    ]);

    $saved = DB::table('security')->first();

    if ($saved->password !== $request->old_password) {
        return back()->withErrors(['old_password' => 'Old password is incorrect']);
    }

    DB::table('security')->update([
        'password' => $request->new_password,
        'updated_at' => now(),
    ]);

    return back()->with('success', 'Password changed successfully!');
}

}
