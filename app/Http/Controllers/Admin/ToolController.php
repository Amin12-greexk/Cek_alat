<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToolController extends Controller
{
    /**
     * Display a listing of the tools.
     */
    public function index()
    {
        $tools = Tool::all(); // Fetch all tools from the database
        return view('admin.tools.index', compact('tools'));
    }

    /**
     * Show the form for creating a new tool.
     */
    public function create()
    {
        return view('admin.tools.create');
    }

    /**
     * Store a newly created tool in the database.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('tool_images', 'public');
        }

        // Create the tool
        $tool = Tool::create($validated);

        // Attach tags
        if ($request->has('tags')) {
            $tags = collect($request->tags)->map(function ($tagName) {
                return Tag::firstOrCreate(['name' => $tagName])->id;
            });
            $tool->tags()->sync($tags); // Attach the tags to the tool
        }

        // Redirect with success message
        return redirect()->route('admin.tools.index')->with('success', 'Tool added successfully with tags.');
    }

    /**
     * Show the form for editing the specified tool.
     */
    public function edit(Tool $tool)
    {
        $tags = $tool->tags->pluck('name')->toArray(); // Retrieve existing tags
        return view('admin.tools.edit', compact('tool', 'tags'));
    }

    /**
     * Update the specified tool in the database.
     */
    public function update(Request $request, Tool $tool)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
        ]);

        // Handle file upload if provided
        if ($request->hasFile('image')) {
            if ($tool->image) {
                Storage::disk('public')->delete($tool->image); // Delete the old image
            }
            $validated['image'] = $request->file('image')->store('tool_images', 'public');
        }

        // Update the tool
        $tool->update($validated);

        // Update tags
        if ($request->has('tags')) {
            $tags = collect($request->tags)->map(function ($tagName) {
                return Tag::firstOrCreate(['name' => $tagName])->id;
            });
            $tool->tags()->sync($tags); // Sync tags to the tool
        }

        return redirect()->route('admin.tools.index')->with('success', 'Tool updated successfully with tags.');
    }

    /**
     * Remove the specified tool from the database.
     */
    public function destroy(Tool $tool)
    {
        // Delete the associated image if it exists
        if ($tool->image) {
            Storage::disk('public')->delete($tool->image);
        }

        // Detach tags
        $tool->tags()->detach();

        // Delete the tool
        $tool->delete();

        return redirect()->route('admin.tools.index')->with('success', 'Tool deleted successfully with its tags.');
    }
}
