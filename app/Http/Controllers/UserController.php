<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $search = request('search');

        if ($search) {
            $users = User::withCount('todos')
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                          ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->where('id', '!=', 1)
                ->orderBy('name')
                ->paginate(20)
                ->withQueryString();
        } else {
            $users = User::withCount('todos')
                ->where('id', '!=', 1)
                ->orderBy('name')
                ->paginate(10);
        }

        return view('user.index', compact('users'));
    }

    public function makeadmin(User $user)
    {
        $user->timestamps = false;
        $user->is_admin = true;
        $user->save();

        return back()->with('success', 'Make admin successfully!');
    }

    public function removeadmin(User $user)
    {
        if ($user->id != 1) {
            $user->timestamps = false;
            $user->is_admin = false;
            $user->save();

            return back()->with('success', 'Remove admin successfully!');
        } else {
            return redirect()->route('user.index')->with('danger', 'Cannot remove admin from super admin!');
        }
    }

    public function destroy(User $user)
    {
        if ($user->id != 1) {
            $user->delete();
            return back()->with('success', 'Delete user successfully!');
        } else {
            return redirect()->route('user.index')->with('danger', 'Delete user failed!');
        }
    }

    public function update(Request $request, User $user)
    {
        // Validasi dan pembaruan data user
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->all());

        return redirect()->route('user.index')->with('success', 'User updated successfully!');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }
}
