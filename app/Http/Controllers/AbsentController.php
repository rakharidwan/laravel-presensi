<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class AbsentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $waktu_masuk = Carbon::parse('08:00:00')->format('H:i:s');
        $waktu_pulang = Carbon::parse('14:00:00')->format('H:i:s');
        $waktu_sekarang = Carbon::now()->format('H:i:s');
        return view('welcome',['waktu_masuk' => $waktu_masuk,'waktu_pulang' => $waktu_pulang,'waktu_sekarang' => $waktu_sekarang]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function absent(Request $request){

        $validated = Validator::make($request->all(),[
            'photo' => ['required'],
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 0,'error'=>$validated->errors(),'alert' => 'danger','message' => 'Harap Selfie Terlebih Dahulu']);
        }
        $karyawan = Karyawan::where('nik',$request->nik)->first();
        $tanggal = Carbon::now()->format('Y-m-d');
        $absensi = Absensi::where('id',$karyawan->id)->whereDate('created_at',$tanggal)->get();
        if ($absensi->count() >= 1) {
            return response()->json(['status' => 0,'alert' => 'primary','message' => 'Anda Sudah Melakukan Absen Hari Ini']);
        }

        $waktu_sekarang = Carbon::now()->format('dmY');
        $image = $request->photo;  // your base64 encoded
        $filename = 'foto_absensi/'.$waktu_sekarang.'/masuk_'.$request->nik.'.jpg';
        $binary_data = base64_decode($image);

        Storage::disk('public')->put($filename, $binary_data);
        

        $jam_masuk = Carbon::parse('08:00:00')->format('H:i:s');
        $jam_masuk_karyawan = Carbon::now()->format('H:i:s');
        $terlambat = null;
        $keterangan = 'HADIR';

        if ($jam_masuk_karyawan > $jam_masuk) {
            $terlambat = Carbon::parse('08:00:00')->diffInMinutes($jam_masuk_karyawan);
            $keterangan = "TELAT";
        }

        $absent = Absensi::create([
            'id_karyawan' => $karyawan->id,
            'jam_masuk' => $jam_masuk_karyawan,
            'keterangan' => $keterangan,
            'pesan' => $request->pesan,
            'foto' => $filename,
            'keterlambatan' => $terlambat,
        ]);

        return response()->json(['status' => 1,'alert' => 'success','message' => 'Hai '.$karyawan->nama.' !'.'<br> Anda Berhasil Absen Hari Ini Pada Pukul '.$jam_masuk_karyawan.' Semangat Ya!']);
    }

    public function validateData(Request $request){
        $validated = Validator::make($request->all(),[
            'nik' => ['required','exists:karyawans,nik'],
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 0,'error'=>$validated->errors(),'alert' =>'danger','message' => 'Nomor NIK Tidak Valid']);
        }

        $karyawan = Karyawan::where('nik',$request->nik)->first();
        $waktu_sekarang = Carbon::now()->format('H:i:s');
        $tanggal = Carbon::now()->format('Y-m-d');
        $waktu_pulang = Carbon::parse('14:00:00')->format('H:i:s');

        if ($waktu_sekarang <= $waktu_pulang) {
            $absensi = Absensi::where('id_karyawan',$karyawan->id)->whereDate('created_at',$tanggal)->count();
            if ($absensi >= 1) {
                return response()->json(['status' => 0,'alert' => 'primary','message' => 'Anda Sudah Melakukan Absen Hari Ini']);
            }
        }

        return response()->json(['status' => 1]);
        
    }

    public function pulang(Request $request){

        $tanggal = Carbon::now()->format('Y-m-d');
        $karyawan = Karyawan::where('nik',$request->nik)->first();
        $absensi = Absensi::where('id_karyawan',$karyawan->id)->whereDate('created_at',$tanggal)->first();
        if ($absensi == null) {
            return response()->json(['status' => 0,'alert' =>'danger','message' => 'Anda Belum Melakukan Absen Hari Ini']);
        }
        
        if ($absensi->jam_keluar != null) {
            return response()->json(['status' => 0,'alert' =>'danger','message' => 'Anda Sudah Melakukan Absen Pulang Hari Ini']);
        }

        $filename = null;
        if ($request->photo != null) {
            $waktu_sekarang = Carbon::now()->format('dmY');
            $image = $request->photo;  // your base64 encoded
            $filename = 'foto_absensi/'.$waktu_sekarang.'/pulang_'.$request->nik.'.jpg';
            $binary_data = base64_decode($image);
    
            Storage::disk('public')->put($filename, $binary_data);
        }

        $waktu_sekarang = Carbon::now()->format('H:i:s');

        $absent = Absensi::where('id_karyawan',$karyawan->id)->whereDate('created_at',$tanggal)->update([
            'jam_keluar' => $waktu_sekarang,
            'foto_pulang' => $filename,
        ]);

        return response()->json(['status' => 1,'alert' => 'success','message' => 'Hai '.$karyawan->nama.' !'.'<br> Anda Berhasil Pulang Hari Ini Pada Pukul '.$waktu_sekarang.' Hati - Hati Dijalan Ya!']);
        
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
    }
}
