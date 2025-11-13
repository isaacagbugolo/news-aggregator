<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserPreference;
use Illuminate\Support\Facades\Auth;

class UserPreferenceController extends Controller
{
    public function show(Request $request)
    {
        $pref = UserPreference::firstOrCreate(['user_id' => Auth::id()]);
        return response()->json($pref);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'sources' => 'nullable|array',
            'categories' => 'nullable|array',
            'authors' => 'nullable|array',
        ]);
        $pref = UserPreference::updateOrCreate(['user_id' => Auth::id()], $data);
        return response()->json($pref);
    }
}

