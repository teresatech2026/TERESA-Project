<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advisory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvisoryController extends Controller
{
    /**
     * Show the form to create a new advisory.
     */
    public function create()
    {
        return view('admin.advisories.create');
    }

    /**
     * Save a new advisory.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
    'title' => 'required|string|max:200',
    'content' => 'required|string',
    'category' => 'nullable|string|max:100',
    'image' => 'nullable|image|max:4096',
    'date_published' => 'required|date',
    'prepared_by' => 'required|string|max:150',
    'position' => 'required|string|max:100',
    'area_of_responsibility' => 'required|string|max:100',
]);

        $imagePath = null;
if ($request->hasFile('image')) {
    $imagePath = $request->file('image')->store('advisory-images', 'supabase');
}

        Advisory::create([
    'admin_id' => auth()->user()->admin->id,
    'title' => $validated['title'],
    'content' => $validated['content'],
    'category' => $validated['category'],
    'image_path' => $imagePath,
    'date_published' => $validated['date_published'],
    'prepared_by' => $validated['prepared_by'],
    'position' => $validated['position'],
    'area_of_responsibility' => $validated['area_of_responsibility'],
]);
        return redirect()->route('market-analytics.index')->with('success', 'Advisory published successfully!');
    }

    /**
     * Delete an advisory.
     */
    public function destroy(Advisory $advisory)
{
    abort_unless($advisory->admin_id === auth()->user()->admin->id, 403);

    if ($advisory->image_path) {
        Storage::disk('supabase')->delete($advisory->image_path);
    }

    $advisory->delete();

    return back()->with('success', 'Advisory deleted.');
}
}