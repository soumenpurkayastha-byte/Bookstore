<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_table;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show signup page
    public function showSignupForm()
    {
        return view('auth.signup');
    }

    // Handle signup form submission
    public function storeSignup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user_tables,email',
            'password' => 'required|string|min:6',
        ]);

        User_table::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_seller' => $request->has('is_seller') ? true : false,
        ]);

        return redirect('/books')->with('success', 'Signup successful!');
    }

    // Show login page
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login form submission
    public function storeLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User_table::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session(['user_id' => $user->id]); // store user session
            return redirect('/books');
        } else {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
    }

 

    // Show user profile page
    public function showProfile()
    {
        $user = User_table::find(session('user_id')); // get current logged-in user
        return view('auth.profile', compact('user'));
    }

    // Handle profile update
    public function updateProfile(Request $request)
    {
        $user = User_table::find(session('user_id'));

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user_tables,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) { // only update if new password is entered
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
