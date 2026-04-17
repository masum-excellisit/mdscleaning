<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function showAdminLoginForm(): View
    {
        return view('auth.admin-login');
    }

    public function login(Request $request): RedirectResponse
    {
        return $this->authenticate($request, false);
    }

    public function adminLogin(Request $request): RedirectResponse
    {
        return $this->authenticate($request, true);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }

    /**
     * Merge a guest session cart into the authenticated user's cart.
     */
    protected function mergeGuestCart(Request $request): void
    {
        $sessionId = $request->session()->getId();
        $guestCart = Cart::where('session_id', $sessionId)->whereNull('user_id')->with('items')->first();

        if (! $guestCart || $guestCart->items->isEmpty()) {
            $guestCart?->delete();
            return;
        }

        $userCart = Cart::firstOrCreate(['user_id' => Auth::id()], ['session_id' => null]);

        DB::transaction(function () use ($guestCart, $userCart) {
            foreach ($guestCart->items as $gi) {
                $existing = CartItem::where('cart_id', $userCart->id)
                    ->where('product_id', $gi->product_id)
                    ->where('variant_id', $gi->variant_id)
                    ->first();

                if ($existing) {
                    $existing->update(['qty' => $existing->qty + $gi->qty]);
                } else {
                    CartItem::create([
                        'cart_id'    => $userCart->id,
                        'product_id' => $gi->product_id,
                        'variant_id' => $gi->variant_id,
                        'qty'        => $gi->qty,
                        'price'      => $gi->price,
                    ]);
                }
            }
            $guestCart->items()->delete();
            $guestCart->delete();
        });
    }

    protected function authenticate(Request $request, bool $adminPortal): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $user = Auth::user();

        if ($user->status === 'banned') {
            $this->logoutRejectedUser($request);

            throw ValidationException::withMessages([
                'email' => 'Your account has been disabled. Please contact support.',
            ]);
        }

        if ($adminPortal && ! $user->isAdmin()) {
            $this->logoutRejectedUser($request);

            throw ValidationException::withMessages([
                'email' => 'This login is only for admin accounts.',
            ]);
        }

        if (! $adminPortal && $user->isAdmin()) {
            $this->logoutRejectedUser($request);

            throw ValidationException::withMessages([
                'email' => 'Admin accounts must sign in at /admin/login.',
            ]);
        }

        $request->session()->regenerate();

        if ($adminPortal) {
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        $this->mergeGuestCart($request);

        return redirect()->intended(route('account.dashboard'))
            ->with('success', 'Welcome back, ' . $user->name . '!');
    }

    protected function logoutRejectedUser(Request $request): void
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
