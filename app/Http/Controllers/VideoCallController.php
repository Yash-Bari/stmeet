<?php

// app/Http/Controllers/VideoCallController.php
namespace App\Http\Controllers;

use App\Models\TempSession;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VideoCallController extends Controller
{
    public function chat($session_id)
    {
        if (!session()->has('user_preferences')) {
            return redirect()->route('home');
        }
        return view('videochat.index', compact('session_id'));
    }

    public function createSession(Request $request)
    {
        // Clean up old sessions (inactive for more than 5 minutes)
        TempSession::where('last_active', '<', Carbon::now()->subMinutes(5))->delete();

        $session = TempSession::create([
            'session_id' => session('temp_session_id'),
            'is_available' => true,
            'preferences' => session('user_preferences'),
            'last_active' => Carbon::now()
        ]);

        return response()->json([
            'session_id' => $session->session_id
        ]);
    }

    public function findMatch(Request $request)
    {
        $preferences = session('user_preferences');
        
        // Update last active timestamp
        TempSession::where('session_id', session('temp_session_id'))
            ->update(['last_active' => Carbon::now()]);

        // Find matching available session
        $query = TempSession::where('is_available', true)
            ->where('session_id', '!=', session('temp_session_id'));

        // Apply preference filters if "any" is not selected
        if ($preferences['preferred_gender'] !== 'any') {
            $query->whereJsonContains('preferences->gender', $preferences['preferred_gender']);
        }

        $query->whereJsonContains('preferences->age', function ($q) use ($preferences) {
            $q->whereBetween('age', [
                $preferences['preferred_age_min'],
                $preferences['preferred_age_max']
            ]);
        });

        // If interests are specified, try to match at least one
        if (!empty($preferences['preferred_interests'])) {
            $query->whereJsonContains('preferences->interests', function ($q) use ($preferences) {
                $q->whereIn('interests', $preferences['preferred_interests']);
            });
        }

        $match = $query->first();

        if (!$match) {
            // If no match found with preferences, find random available session
            $match = TempSession::where('is_available', true)
                ->where('session_id', '!=', session('temp_session_id'))
                ->inRandomOrder()
                ->first();
        }

        if ($match) {
            $match->update(['is_available' => false]);
            TempSession::where('session_id', session('temp_session_id'))
                ->update(['is_available' => false]);

            return response()->json([
                'matched_session_id' => $match->session_id
            ]);
        }

        return response()->json([
            'message' => 'No available matches found'
        ], 404);
    }

    public function endSession(Request $request)
    {
        TempSession::where('session_id', session('temp_session_id'))->delete();
        session()->forget(['user_preferences', 'temp_session_id']);
        return response()->json(['message' => 'Session ended']);
    }
}