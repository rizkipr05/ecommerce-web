<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        $role = $this->normalizeRole($request->route('role') ?? User::ROLE_CUSTOMER);

        return view('auth.login', [
            'role' => $role,
            'title' => ucfirst($role) . ' Login',
        ]);
    }

    public function showRegister(Request $request)
    {
        $role = $this->normalizeRole($request->route('role') ?? User::ROLE_CUSTOMER);

        return view('auth.register', [
            'role' => $role,
            'title' => ucfirst($role) . ' Register',
        ]);
    }

    public function login(Request $request)
    {
        $role = $this->normalizeRole($request->route('role') ?? User::ROLE_CUSTOMER);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        $user = $request->user();

        if (!$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => ['Akun Anda dinonaktifkan.'],
            ]);
        }

        if ($user->role !== $role) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => ['Role tidak sesuai untuk login ini.'],
            ]);
        }

        $request->session()->regenerate();

        return redirect($this->redirectPath($role));
    }

    public function register(Request $request)
    {
        $role = $this->normalizeRole($request->route('role') ?? User::ROLE_CUSTOMER);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $role,
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect($this->redirectPath($role));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/beranda');
    }

    private function normalizeRole(string $role): string
    {
        $role = strtolower($role);

        if (!in_array($role, [User::ROLE_ADMIN, User::ROLE_SELLER, User::ROLE_CUSTOMER], true)) {
            abort(404);
        }

        return $role;
    }

    private function redirectPath(string $role): string
    {
        return match ($role) {
            User::ROLE_ADMIN => '/admin/beranda',
            User::ROLE_SELLER => '/seller/beranda',
            default => '/beranda',
        };
    }
}
