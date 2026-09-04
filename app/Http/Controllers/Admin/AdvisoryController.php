<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advisory;
use App\Models\AdvisoryImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'images' => 'nullable|array',
            'images.*' => 'image|max:4096',
            'date_published' => 'required|date',
            'prepared_by' => 'required|string|max:150',
            'position' => 'required|string|max:100',
            'area_of_responsibility' => 'required|string|max:100',
        ]);

        $advisory = Advisory::create([
            'admin_id' => auth()->user()->admin->id,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category' => $validated['category'],
            'date_published' => $validated['date_published'],
            'prepared_by' => $validated['prepared_by'],
            'position' => $validated['position'],
            'area_of_responsibility' => $validated['area_of_responsibility'],
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('advisory-images', 'supabase');

                AdvisoryImage::create([
                    'advisory_id' => $advisory->id,
                    'image_path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        // Notify every farmer and buyer that a new advisory was published.
        $recipientIds = User::whereIn('role', ['farmer', 'buyer'])->pluck('id');

        foreach ($recipientIds as $userId) {
            \App\Models\Notification::notify(
                $userId,
                'new_advisory',
                'New Advisory: ' . $advisory->title,
                Str::limit($advisory->content, 150),
                route('market-analytics.index')
            );
        }

        return redirect()->route('market-analytics.index')->with('success', 'Advisory published successfully!');
    }

    /**
     * Delete an advisory.
     */
    public function destroy(Advisory $advisory)
    {
        abort_unless($advisory->admin_id === auth()->user()->admin->id, 403);

        // Clean up the old single-image column, if this advisory predates multi-image support.
        if ($advisory->image_path) {
            Storage::disk('supabase')->delete($advisory->image_path);
        }

        // Clean up every image in the new advisory_images table.
        foreach ($advisory->images as $image) {
            Storage::disk('supabase')->delete($image->image_path);
        }

        $advisory->delete();

        return back()->with('success', 'Advisory deleted.');
    }
}