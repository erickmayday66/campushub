<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerSettingsController extends Controller
{
    // Show general settings form
    public function edit()
    {
        return view('manager.settings.edit');
    }

    // Update general settings (example)
    public function update(Request $request)
    {
        // Your update logic here

        return redirect()->route('manager.settings.edit')->with('success', 'Settings updated.');
    }

    // Show password change form
    public function editPassword()
    {
        return view('manager.settings.password_edit');
    }

    // Handle password update
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],  // Laravel 8+ validation rule to check current password
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = $request->user(); // Get currently authenticated user via request

        $user->password = Hash::make($request->password);
        $user->save();

        // Redirect to the main manager settings page instead of password page
        return redirect()->route('manager.settings.edit')->with('success', 'Password changed successfully.');
    }
}
