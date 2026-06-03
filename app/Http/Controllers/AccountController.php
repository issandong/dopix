<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $currentTier = $user->subscriptionTier ?? 'Free';
        $usage = $user->verifications_this_month ?? 0;

        return view('account.show', compact('user', 'currentTier', 'usage'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sport' => 'nullable|string|max:255',
            'federation' => 'nullable|string|max:255',
            'competitionLevel' => 'nullable|string',
            'allergies' => 'nullable|array',
        ]);

        $validated['allergies'] = json_encode($request->allergies ?? []);
        $user->update($validated);

        return redirect()->route('account.show')->with('status', 'account-updated');
    }
}
