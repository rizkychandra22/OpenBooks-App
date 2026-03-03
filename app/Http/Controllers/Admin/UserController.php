<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'required|string|max:20',
            'username' => 'required|string|unique:users,username,'.$user->id,
            'password' => 'nullable|string|min:8',
        ]);

        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return back()->with('message', 'Data member berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('message', 'Data member berhasil dihapus.');
    }
}
