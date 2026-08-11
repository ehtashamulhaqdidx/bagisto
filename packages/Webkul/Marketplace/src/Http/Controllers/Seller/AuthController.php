<?php

namespace Webkul\Marketplace\Http\Controllers\Seller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Webkul\Marketplace\Repositories\SellerRepository;

class AuthController extends Controller
{
    public function __construct(protected SellerRepository $sellerRepository)
    {
    }

    public function showLogin(): View
    {
        return view('marketplace::seller.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('seller')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('marketplace.seller.dashboard');
        }

        return back()->withErrors(['email' => 'These credentials do not match our records.'])->onlyInput('email');
    }

    public function showRegister(): View
    {
        return view('marketplace::seller.auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:sellers,email'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'shop_title' => ['required', 'string', 'max:255'],
            'shop_url'   => ['required', 'string', 'alpha_dash', 'max:255', 'unique:sellers,shop_url'],
            'phone'      => ['nullable', 'string', 'max:32'],
        ]);

        $seller = $this->sellerRepository->create($data);

        Auth::guard('seller')->login($seller);

        return redirect()->route('marketplace.seller.status');
    }

    public function status(): View
    {
        return view('marketplace::seller.auth.status', [
            'seller' => Auth::guard('seller')->user(),
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('seller')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('marketplace.seller.login');
    }
}
