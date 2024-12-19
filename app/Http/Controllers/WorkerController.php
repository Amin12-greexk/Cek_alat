<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\ToolPart;
use App\Models\Submission;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function tools()
    {
        $tools = Tool::all();
        return view('worker.tools.index', compact('tools'));
    }

    public function inspect(Tool $tool)
    {
        // Fetch all parts for the selected tool
        $parts = ToolPart::where('tool_id', $tool->id)->get();
        return view('worker.tools.inspect', compact('tool', 'parts'));
    }

    public function submitInspection(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'responses' => 'required|array',
            'expiration_date' => 'required|date|after:today',
            'inspection_date' => 'required|date',
            'company_name' => 'required|string|max:255',
        ]);

        foreach ($validated['responses'] as $response) {
            if (strtolower($response) === 'no') {
                // Redirect immediately if the tool is unworthy
                return redirect()->route('worker.feedback', $tool->id)
                    ->with('status', 'The tool is not worthy.')
                    ->with('expiration_date', $validated['expiration_date']);
            }
        }

        // Save the submission (if all responses are "yes")
        $submission = Submission::create([
            'tool_id' => $tool->id,
            'submission_date' => now(),
            'worker_response' => json_encode($validated['responses']),
            'is_feasible' => true,
            'expiration_date' => $validated['expiration_date'],
            'inspection_date' => $validated['inspection_date'],
            'company_name' => $validated['company_name'],
        ]);

        return redirect()->route('worker.feedback', $tool->id)
            ->with('status', 'The tool is worthy.')
            ->with('tool_name', $tool->name)
            ->with('expiration_date', $validated['expiration_date'])
            ->with('submission_id', $submission->id);
    }

    public function exportSubmission(Submission $submission)
    {
        // Prepare data for export
        $data = [
            ['Tool Name', 'Part Name', 'Validation Description', 'Response', 'Inspection Date', 'Expiration Date', 'Company Name', 'Tags'],
        ];

        $tool = $submission->tool;
        $responses = json_decode($submission->worker_response, true);
        $parts = $tool->parts;

        foreach ($parts as $part) {
            $data[] = [
                $tool->name,
                $part->part_name,
                $part->description,
                $responses[$part->id] ?? 'N/A', // Match response with part
                $submission->inspection_date,
                $submission->expiration_date,
                $submission->company_name,
                implode(', ', $tool->tags->pluck('name')->toArray()),
            ];
        }

        // Create a temporary CSV file
        $filename = storage_path('app/temp_submission_' . $submission->id . '.csv');
        $handle = fopen($filename, 'w');
        foreach ($data as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);

        // Return the file as a download
        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
