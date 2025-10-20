<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function tampilkanFormLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login user
     */
    public function proses_login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username harus diisi.',
            'password.required' => 'Password harus diisi.',
        ]);

        try {
            $user = User::where('username', $request->username)
                ->where('status_id', 1) // Hanya user yang aktif
                ->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'username' => 'Username atau password salah.',
                ]);
            }

            // Get user role before proceeding
            $roleName = $user->role?->nama;
            if (!$roleName) {
                throw ValidationException::withMessages([
                    'username' => 'Akun tidak memiliki role yang valid.',
                ]);
            }

            // Verify route exists
            if (!Route::has("dashboard.$roleName")) {
                throw ValidationException::withMessages([
                    'username' => 'Tipe akun tidak valid atau akses belum dikonfigurasi.',
                ]);
            }

            // Regenerate session to prevent fixation attacks
            $request->session()->regenerate();

            // Login user
            Auth::login($user, $request->boolean('remember'));

            // Get dashboard URL
            $dashboardUrl = route("dashboard.$roleName");

            return redirect()->intended($dashboardUrl);

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'username' => 'Terjadi kesalahan saat proses login. Silakan coba lagi.',
            ])->withInput($request->except('password'));
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('sukses', 'Anda berhasil logout.');
    }

    /**
     * Redirect ke dashboard sesuai role
     */
    protected function redirectToDashboard(User $user)
    {
        $role = $user->role->nama;

        return match($role) {
            'dekan' => redirect()->route('dashboard.dekan')
                ->with('sukses', 'Selamat datang, ' . $user->nama . ' (Dekan)'),
            'kaprodi' => redirect()->route('dashboard.kaprodi')
                ->with('sukses', 'Selamat datang, ' . $user->nama . ' (Kaprodi)'),
            'dosen' => redirect()->route('dosen.index')
                ->with('sukses', 'Selamat datang, ' . $user->nama . ' (Dosen)'),
            'kosma' => redirect()->route('dashboard.kosma')
                ->with('sukses', 'Selamat datang, ' . $user->nama . ' (KOSMA)'),
            'mahasiswa' => redirect()->route('dashboard.mahasiswa')
                ->with('sukses', 'Selamat datang, ' . $user->nama . ' (Mahasiswa)'),
            'sekprodi' => redirect()->route('dashboard.sekprodi')
                ->with('sukses', 'Selamat datang, ' . $user->nama . ' (Sekprodi)'),
            default => redirect('/')
        };
    }
}
