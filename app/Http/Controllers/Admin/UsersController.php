<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', User::class);

        $roles = Role::all();

        return inertia('Admin/Users/index', ['roles' => $roles]);
    }

    public function search(Request $request)
    {
        Gate::authorize('viewAny', User::class);

        $query = $request->input('query');

        $users = User::with('role');

        if ($query) {
            $users->where('email', 'like', '%' . $query . '%');
        }

        $result = $users->paginate(12);

        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);

        Gate::authorize('update', $user);

        $user->role_id = $validated['role_id'];

        $user->save();

        return redirect()->route('users.index')->with('success', 'Rôle mis à jour avec succès.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        Gate::authorize('delete', $user);

        if ($user->role && $user->role->name === \App\Models\Role::MASTER) {
            return redirect()->back()->with('error', 'Impossible de supprimer un utilisateur avec le rôle Master.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Utilisateur supprimé avec succès.');
    }
}
