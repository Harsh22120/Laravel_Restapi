<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $request->validate([
            'adar_card_no' => 'required|string|max:20|unique:user_profiles,adar_card_no,' . Auth::id(),
            'gst_number' => 'required|string|max:20|unique:user_profiles,gst_number,' . Auth::id(),
        ]);

        try {
            $user = Auth::user();
            $profile = $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                ['adar_card_no' => $request->adar_card_no, 'gst_number' => $request->gst_number]
            );

            return response()->json(['message' => 'Profile updated successfully', 'profile' => $profile], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Profile update failed', 'error' => $e->getMessage()], 500);
        }
    }
}
