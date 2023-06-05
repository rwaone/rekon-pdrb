<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Satker;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.index', [
            'users' => User::all(),
            'satkers' => Satker::all(),
        ]);
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user.edit', [
            'user' => $user,
            'satkers' => Satker::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileUpdateRequest $request, User $user)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return redirect('user')->with('status', 'profile-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
