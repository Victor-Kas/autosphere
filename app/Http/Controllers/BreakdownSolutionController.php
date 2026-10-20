<?php

namespace App\Http\Controllers;

use App\Models\Breakdown;
use App\Models\BreakdownSolution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BreakdownSolutionController extends Controller
{
    public function store(Request $request, Breakdown $breakdown): RedirectResponse
    {
        $validated = $request->validate([
            'body' => 'required|string|min:10|max:5000',
        ]);

        $breakdown->solutions()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

        return redirect()->route('breakdowns.show', $breakdown)->with('success', 'Your solution has been posted.');
    }


    public function accept(Request $request, Breakdown $breakdown, BreakdownSolution $solution): RedirectResponse {

        // Only the breakdown author can accept a solution
        abort_unless(
            $request->user()->id === $breakdown->user_id,
            403
        );

        // Ensure the solution belongs to this breakdown
        abort_unless(
            $solution->breakdown_id === $breakdown->id,
            404
        );

        DB::transaction(function () use ($breakdown, $solution) {

            // Lock the breakdown to prevent concurrent acceptance
            $lockedBreakdown = Breakdown::whereKey($breakdown->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Don't allow acceptance once resolved
            abort_if($lockedBreakdown->status === 'resolved', 409);

            // Mark the selected response as accepted
            $solution->update([
                'is_accepted' => true,
            ]);

            // Mark the breakdown as resolved
            $lockedBreakdown->update([
                'status' => 'resolved',
            ]);
        });

        return redirect()
            ->route('breakdowns.show', $breakdown)
            ->with('success', 'Solution accepted! Breakdown resolved.');
    }

}
