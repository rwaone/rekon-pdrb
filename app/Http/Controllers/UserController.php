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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'satker_id' => ['required'],
            'role' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        // dd($request);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role'  => $request->role,
            'satker_id' => $request->satker_id,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Auth::login($user);

        return redirect('user');
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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'satker_id' => ['required'],
            'role' => ['required'],
        ];

        if($request->username != $user->username){
            $rules['username'] = ['required', 'string', 'max:255', 'unique:'.User::class];
        }
        
        if($request->email != $user->email){
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:'.User::class];
        }

        $request->validate($rules);

        $updateData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'satker_id' => $request->satker_id,
            'role' => $request->role
        ];

        User::where('id', $user->id)->update($updateData);


        return redirect('user')->with('notif', 'user-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect('user')->with('notif', 'Data berhasil dihapus!');
    }
}
