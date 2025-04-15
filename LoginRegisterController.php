<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Siswas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LoginRegisterController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.akun.index', compact('users'));
    }

    public function create()
    {
        return view('admin.akun.create');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => 'required|string|max:250',
            'email'    => 'required|string|max:250|unique:users',
            'password' => 'required|min:8|confirmed',
            'usertype' => 'required'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => $request->usertype
        ]);

        return redirect()->route('akun.index')->with('success', 'Data Berhasil Disimpan!');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route(
                Auth::user()->usertype == 'admin' ? 'admin.dashboard' : 'home'
            )->with('success', 'Kamu berhasil log in');
        }

        return back()->withErrors([
            'email' => "Email kamu tidak terdaftar, silakan coba lagi",
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Kamu berhasil logout');
    }

    // Gunakan Model Binding untuk mengambil data user
    public function edit($id)
    {
        $akun=User::findOrFail($id);
        return view('admin.akun.edit',compact('akun'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name'     => 'required|string|max:250',
            'usertype' => 'required'
        ]);

        $user->update([
            'name'     => $request->name,
            'usertype' => $request->usertype
        ]);

        return redirect()->route('akun.edit', $user->id)->with('success', 'Data berhasil diubah');
    }

    public function updateEmail(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|max:250|unique:users,email,' . $user->id
        ]);

        $user->update([
            'email' => $request->email
        ]);

        return redirect()->route('akun.edit', $user->id)->with('success', 'Email berhasil diubah');
    }

    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'password' => 'required|min:8|confirmed'
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('akun.edit', $user->id)->with('success', 'Password berhasil diubah');
    }

    
    // Hapus akun user beserta data siswa (jika ada)
     
    public function destroy(User $user): RedirectResponse
    {
        // Cari id siswa berdasarkan id_user dari tabel 'siswas'
        $siswaId = DB::table('siswas')
            ->where('id_user', $user->id)
            ->value('id');

        // Jika data siswa ditemukan, hapus data siswa tersebut
        if ($siswaId) {
            $this->destroySiswa($siswasId);
        }

        // Hapus data user
        $user->delete();

        // Redirect ke route 'akun.index' dengan pesan sukses
        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus!');
    }

    
     //  Hapus data siswa dan file gambar (jika ada)
    
    protected function destroySiswa(string $id): void
    {
        // Ambil data siswa berdasarkan id menggunakan Eloquent
        $siswas = Siswa::findOrFail($id);

        // Hapus gambar siswa dari storage, jika ada
        if (!empty($siswa->image)) {
            Storage::delete('public/siswa/' . $siswas->image);
        }

        // Hapus data siswa
        $siswas->delete();
    }
}