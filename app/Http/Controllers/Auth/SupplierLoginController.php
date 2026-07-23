<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SupplierLoginController extends Controller
{
    public function create(): View
    {
        return view('auth.supplier-login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'These credentials do not match our records.',
            ])->onlyInput('email');
        }

        if (! Auth::user()->isSupplier()) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'This account is not a supplier account. Please use the regular login page.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('supplier.quotations.index'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('supplier.login');
    }
}
