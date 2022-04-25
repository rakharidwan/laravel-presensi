<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Image;
use App\DataTables\KaryawansDataTable;
use Carbon\Carbon;
// use Intervention\Image\ImageManagerStatic as Image;


class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KaryawansDataTable $dataTable)
    {
        //
        $jabatan = Jabatan::orderBy('created_at','desc')->get();
        // $karyawan = Karyawan::with(['jabatan'])->orderBy('created_at','desc')->get();

        return $dataTable->render('pages.karyawan.index-karyawan',['jabatan' => $jabatan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validated = Validator::make($request->all(),[
            'nik' => ['required','unique:karyawans,nik','numeric','digits_between:11,13'],
            'nama' => ['required','max:60','min:1','regex:/^[\pL\s\-]+$/u'],
            'entitas' => ['required','max:60','min:1'],
            'jabatan' => ['required','exists:jabatans,id'],
            'nomor_hp' => ['nullable','numeric','digits_between:13,14'],
            'foto' => ['nullable','image','mimes:jpg,png','max:8000'],
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 0,'error'=>$validated->errors()]);
        }

        $foto = null;
        if ($request->foto != null) {
            $filename = 'karyawan_'.$request->nik.'.jpg';
            $image_resize = Image::make($request->file('foto')->getRealPath())->fit(300)->encode('jpg');
            Storage::disk('public')->put('foto_karyawan/'.$filename, $image_resize);
            $foto = 'foto_karyawan/'.$filename;
        }

        $karyawan = Karyawan::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'id_jabatan' => $request->jabatan,
            'entitas' => $request->entitas,
            'nomor_hp' => $request->nomor_hp,
            'foto' => $foto
        ]);

        Session::flash('success', 'Data Karyawan Berhasil Ditambahkan'); 

        return response()->json(['status' => 1]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $karyawan = Karyawan::with('jabatan')->where('id',$id)->first();
        return response()->json(['karyawan' => $karyawan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validated = Validator::make($request->all(),[
            'nik' => ['required','unique:karyawans,nik,'.$id,'numeric','digits_between:11,14'],
            'nama' => ['required','max:60','min:1','regex:/^[\pL\s\-]+$/u'],
            'entitas' => ['required','max:60','min:1'],
            'jabatan' => ['required','exists:jabatans,id'],
            'nomor_hp' => ['nullable','numeric','digits_between:13,14'],
            'foto' => ['nullable','image','mimes:jpg,png','max:8000'],
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 0,'error'=>$validated->errors()]);
        }

        $karyawan = Karyawan::with('jabatan')->where('id',$id)->first();
        
        $foto = null;
        if ($request->foto != null) {
            $filename = 'karyawan_'.$request->nik.'.jpg';
            $image_resize = Image::make($request->file('foto')->getRealPath())->fit(300)->encode('jpg');

            Storage::disk('public')->delete($karyawan->foto);
            Storage::disk('public')->put('foto_karyawan/'.$filename, $image_resize);
            $foto = 'foto_karyawan/'.$filename;
        }

        $karyawan = Karyawan::where('id',$id)->update([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'id_jabatan' => $request->jabatan,
            'entitas' => $request->entitas,
            'nomor_hp' => $request->nomor_hp,
            'foto' => $foto
        ]);

        Session::flash('success', 'Data Karyawan Berhasil Diperbarui'); 

        return response()->json(['status' => 1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $karyawan = Karyawan::with('jabatan')->where('id',$id)->first();
        $karyawan->delete();
        Storage::disk('public')->delete($karyawan->foto);
        Session::flash('success', 'Data Karyawan Berhasil Diperbarui');
        
        return redirect()->back();

    }
}
