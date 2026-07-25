<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Admin: view customer accounts, optionally searched by name.
     */
    public function index(Request $request): View
    {
        $query = User::where('role', 'user');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->string('search').'%');
        }

        $users = $query->orderBy('name')->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Admin: remove an inappropriate customer account.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return back()->with('success', 'User removed.');
    }
}