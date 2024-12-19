<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\Tool;
use Carbon\Carbon;

class SubmissionController extends Controller
{
    /**
     * Display a listing of submissions.
     */
    public function index()
    {
        $submissions = Submission::with(['tool', 'part'])->get();
        return view('admin.submissions.index', compact('submissions'));
    }

    /**
     * Update the status of a submission.
     */
    public function updateStatus(Request $request, Submission $submission)
    {
        $submission->update(['is_feasible' => $request->is_feasible]);

        return redirect()->route('admin.submissions.index')->with('success', 'Submission status updated successfully.');
    }
    public function submitTool(Request $request, Tool $tool)
    {
        // Example worker responses from the form submission
        $responses = $request->input('responses'); // Assume this is an array of Yes/No answers
        $isFeasible = true;

        // Check for any "No" response
        foreach ($responses as $response) {
            if (strtolower($response) === 'no') {
                $isFeasible = false;
            }
        }

        // Calculate expiration date (1 year from submission date)
        $expirationDate = Carbon::now()->addYear();

        // Store the submission
        Submission::create([
            'tool_id' => $tool->id,
            'submission_date' => now(),
            'worker_response' => json_encode($responses), // Store as JSON
            'is_feasible' => $isFeasible,
            'expiration_date' => $expirationDate,
        ]);

        // Redirect to a feedback page for the worker
        return redirect()->route('worker.feedback', ['tool' => $tool->id])
            ->with('status', $isFeasible ? 'Tool is feasible' : 'Tool is not feasible')
            ->with('expiration_date', $expirationDate->format('Y-m-d'));
    }
}

