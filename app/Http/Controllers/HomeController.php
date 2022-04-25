<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $jumlah_karyawan = Karyawan::count();
        return view('home',['jumlah_karyawan' => $jumlah_karyawan]);
    }

    public function absent()
    {
        
        $waktu_sekarang = Carbon::now()->format('Y-m-d');
        $absent = Absensi::with(['karyawan'])->orderBy('created_at','desc')->whereDate('created_at',$waktu_sekarang)->get();
        $not_yet_absent = Karyawan::whereNotIn('id',function($query) {
            $query->select('id_karyawan')->from('absensis');
         })->count();
        $absent_count = Absensi::whereDate('created_at',$waktu_sekarang)->count();

        return response()->json(['absent' => $absent,'absent_count' => $absent_count,'not_yet_absent' => $not_yet_absent]);

    }

    public function editProfile($id)
    {
        $id = Auth::user()->id;
        $user = User::where('id',$id)->first();

        return view('pages.profile.index-profile',['user' => $user]);
    }

    public function updateProfil(Request $request, $id)
    {   

        $validated = Validator::make($request->all(),[
            'username' => ['required','min:3','max:25','regex:/^[a-za-z0-9._]*(?:[._][a-za-z0-9]+)*$/','unique:users,username,'.$id],
            'email' => ['required','email','unique:users,email,'.$id],
            'password' => ['required','confirmed'],
            'nama' => ['required','max:35','min:3','regex:/^[\pL\s\-]+$/u'],
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $update_user = User::where('id',$id)->update([
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->back()->with(['success' => 'Profil Berhasil Diubah']);
    }
    
   
}
