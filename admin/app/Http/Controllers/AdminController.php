<?php

namespace App\Http\Controllers;
use App\Models\Admin;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin(request $request)
    {
        $search = $request-> input('search');

        $admins = Admin::when($search, function ($query, $search) {
            return $query->where('firstname', 'like', "%{$search}%")
                         ->orWhere('lastname', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })->get();
        return view('admin', compact('admins'));
    }
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->back()->with('success', 'Admin deleted successfully.');
    }
    public function toggleStatus($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->status = !$admin->status;
        $admin->save();

        return response()->json([
            'success' => true,
            'status' => $admin->status
        ]);
    }

}
