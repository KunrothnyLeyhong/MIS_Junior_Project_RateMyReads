<?php

namespace App\Http\Controllers;
 use App\Models\User;
use Illuminate\Http\Request;

class RegisterUserController extends Controller
{
    public function registers()
    {
        $search = request('search');

        $users = User::when($search, function ($query, $search) {
            return $query->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })->paginate(5);

        return view('user.registers', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.detailuser', compact('user'));
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function updateStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status; // Assuming status is boolean
        $user->save();

        return redirect()->back()->with('success', 'User status updated.');
    }

}
