<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index():View{
        $siswas = DB::table('siswas')
        ->join('users','siswas.id_user','=','users.id')
        ->select(
            'siswas.*',
            'users.name',
            'users.email'
        )
        ->paginate(10);

        if(request('cari')){
            $siswas = $this->search(request('cari'));
        }

        return view('admin.siswa.index', compact('siswas'));
    }

    public function create():View {
        return view('admin.siswa.create');
    }
     public function store(Request $request):RedirectResponse{
        //validasi
        $validate = $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nis' => 'required|numeric',
            'tingkatan' => 'required',
            'jurusan' => 'required',
            'kelas' => 'required',
            'hp' => 'required|numeric',
        ]);

        $image = $request->file('image');
        $image->storeAs('public/siswas', $image->hashName(), 'public');

        $id_akun = $this->insertAccount($request->name, $request->email, $request->password);

        Siswa::create([
            'id_user' => $id_akun,
            'image'  => $image->hashName(),
            'nis' => $request->nis,
            'tingkatan' => $request->tingkatan,
            'jurusan' => $request->jurusan,
            'kelas' => $request->kelas,
            'hp' => $request->hp,
            'status' => 1
        ]);

        return redirect()->route('siswa.index')->with(['success' =>'Data Berhasil Disimpan!']);
     }

     public function insertAccount(string $name, string $email, string $password){
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'usertype' => 'siswa'
        ]);

        $id = DB::table('users')->where('email',$email)->value('id');
        return $id;
     }
     public function show(string $id):View{

        $siswa = DB::table('siswas')
        ->join('users', 'siswas.id_user', '=', 'users.id')
        ->select(
            'siswas.*',
            'users.name',
            'users.email'
        )
        ->where('siswas.id',$id)
        ->first();

        return view('admin.siswa.show', compact('siswa'));
     }

     public function search(string $cari){
        $siswas = DB::table('siswas')
        ->join('users', 'siswas.id_user', '=', 'users.id')
        ->select(
            'siswas.*',
            'users.name',
            'users.email'
        )->where('users.name', 'like', '%' . $cari . '%')
        ->orWhere('siswas.nis', 'like', '%' . $cari . '%')
        ->orWhere('users.email', 'like', '%' . $cari . '%')
        ->paginate(10);

        return $siswas;
     }

     public function edit(string $id){

        $siswa = DB::table('siswas')
        ->join('users', 'siswas.id_user', '=', 'users.id')
        ->select(
            'siswas.*',
            'users.name',
            'users.email'
        )
        ->where('siswas.id', $id)
        ->first();

        return view('admin.siswa.edit', compact('siswa'));
     }

     public function update(Request $request, $id):RedirectResponse{

        $validate = $request->validate([
            'name' => 'required|string|max:250',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nis' => 'required|numeric',
            'tingkatan' => 'required',
            'jurusan' => 'required',
            'kelas' => 'required',
            'hp' => 'required|numeric',
            'status' => 'required'
        ]);

        $datas = Siswa::findOrFail($id);

        $this->editAccount($request->name, $id);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $image->storeAs('public/siswas', $image->hashName(), 'public');
            Storage::disk('public')->delete('siswas/' . $datas->image);

            $datas->update([
            'image'  => $image->hashName(),
            'nis' => $request->nis,
            'tingkatan' => $request->tingkatan,
            'jurusan' => $request->jurusan,
            'kelas' => $request->kelas,
            'hp' => $request->hp,
            'status' => $request->status
            ]);
        } else {
            $datas->update([
                'nis' => $request->nis,
                'tingkatan' => $request->tingkatan,
                'jurusan' => $request->jurusan,
                'kelas' => $request->kelas,
                'hp' => $request->hp,
                'status' => $request->status
                ]);
        }

        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Diubah' ]);
     }

     public function editAccount(string $name, string $id){
        $siswa = DB::table('siswas')->where('id', $id)->value('id_user');
        $user = User::findOrFail($siswa);

        $user->update([
            'name' => $name
        ]);
     }

     public function destroy ($id):RedirectResponse{
        $this->destroyUser($id);
        $post = Siswa::findOrFail($id);
        Storage::disk('public')->delete('siswas/' . $post->image);

        $post->delete();

        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Dihapus']);

     }

     public function destroyUser(string $id){
        $siswa = DB::table('siswas')->where('id', $id)->value('id_user');
        $user = User::findOrFail($siswa);

        $user->delete();
     }
}
