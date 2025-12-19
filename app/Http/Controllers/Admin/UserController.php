<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // List all users
    public function index()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    // Toggle user active status
    public function toggleStatus(User $user)
    {
        // Prevent deactivating self
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot deactivate your own account');
        }

        $isActive = $user->is_active ?? true;
        $user->update(['is_active' => !$isActive]);

        $status = !$isActive ? 'deactivated' : 'activated';
        return back()->with('success', "User {$status} successfully");
    }

    // Delete user
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully');
    }
}
