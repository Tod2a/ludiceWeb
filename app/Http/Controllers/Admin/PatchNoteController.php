<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PatchNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PatchNoteController extends Controller
{
    public function store(Request $request)
    {
        Gate::authorize('create', PatchNote::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $userId = Auth::id();

        $patchNote = PatchNote::make();
        $patchNote->title = $request->title;
        $patchNote->description = $request->description;
        $patchNote->user_id = $userId;

        $patchNote->save();

        return redirect()->back()->with('success', 'Patchnote ajouté');
    }
}
