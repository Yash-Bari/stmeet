<?php

// app/Http/Controllers/ProfileController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showForm()
    {
        return view('welcome');
    }

    public function setPreferences(Request $request)
    {
        $validated = $request->validate([
            'age' => 'required|integer|between:13,100',
            'gender' => 'required|in:male,female,other',
            'interests' => 'required|array',
            'preferred_gender' => 'required|in:male,female,other,any',
            'preferred_age_min' => 'required|integer|between:13,100',
            'preferred_age_max' => 'required|integer|between:13,100|gte:preferred_age_min',
            'preferred_interests' => 'array'
        ]);

        // Store preferences in session
        $request->session()->put('user_preferences', $validated);
        
        // Generate temporary session ID
        $sessionId = uniqid('user_', true);
        $request->session()->put('temp_session_id', $sessionId);

        return redirect()->route('chat', ['session_id' => $sessionId]);
    }
}
