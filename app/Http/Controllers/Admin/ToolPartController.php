<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\ToolPart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToolPartController extends Controller
{
    /**
     * Display a listing of the parts for a specific tool.
     */
    public function index(Tool $tool)
{
    $parts = $tool->parts; // Retrieve parts associated with the tool
    return view('admin.parts.index', compact('tool', 'parts'));
}


    /**
     * Show the form for creating a new part (not used here as we create directly in index).
     */
    public function create()
    {
        abort(404); // Not needed as parts are created via index view
    }

    /**
     * Store a newly created part in the database.
     */
    public function store(Request $request, Tool $tool)
{
    $validated = $request->validate([
        'part_name' => 'required|string|max:255',
        'description' => 'required|string',
        'validation' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('part_images', 'public');
    }

    $tool->parts()->create($validated);

    return redirect()->route('admin.tools.parts.index', $tool)
        ->with('success', 'Part added with validation successfully.');
}


    /**
     * Display the specified part (optional, not used in the current flow).
     */
    public function show(ToolPart $part)
    {
        abort(404); // Not used in the flow
    }

    /**
     * Show the form for editing the specified part.
     */
    public function edit(Tool $tool, ToolPart $part)
{
    // Ensure the part belongs to the tool
    if ($part->tool_id !== $tool->id) {
        abort(404, 'Part not found for this tool.');
    }

    return view('admin.parts.edit', compact('tool', 'part'));
}

public function update(Request $request, Tool $tool, ToolPart $part)
{
    // Ensure the part belongs to the tool
    if ($part->tool_id !== $tool->id) {
        abort(404, 'Part not found for this tool.');
    }

    // Validate the input
    $validated = $request->validate([
        'part_name' => 'required|string|max:255',
        'description' => 'required|string',
        'validation' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Handle image upload if a new image is provided
    if ($request->hasFile('image')) {
        if ($part->image) {
            Storage::disk('public')->delete($part->image);
        }
        $validated['image'] = $request->file('image')->store('part_images', 'public');
    }

    // Update the part
    $part->update($validated);

    return redirect()->route('admin.tools.parts.index', $tool)
        ->with('success', 'Part updated successfully.');
}



    /**
     * Remove the specified part from the database.
     */
    public function destroy(ToolPart $part)
{
    // Delete the associated image if it exists
    if ($part->image) {
        Storage::disk('public')->delete($part->image);
    }

    // Delete the part
    $part->delete();

    return redirect()->back()->with('success', 'Part deleted successfully.');
}



}
