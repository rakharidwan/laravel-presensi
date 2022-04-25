<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AbsentDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        $waktu_sekarang = Carbon::now()->format('Y-m-d');
        $waktu = Carbon::now();

        if (request('date')) {
            $waktu_sekarang = Carbon::parse(request('date'));
            $waktu = $waktu_sekarang;
        }

        $absensi = Absensi::with(['karyawan'])->whereDate('created_at',$waktu_sekarang)->orderBy('created_at','DESC')->get();
        
        $not_yet_absent = Karyawan::whereNotIn('id',Absensi::with(['karyawan'])->whereDate('created_at',$waktu_sekarang)->select(['id_karyawan']))->get();

         return view('pages.absensi.index-absensi',['absensi' => $absensi,'waktu' => $waktu,'not_yet_absent' => $not_yet_absent]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showImage($id)
    {
        //
        $absensi = Absensi::where('id',$id)->first();
        return response()->json(['absensi' => $absensi]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function absentManual(Request $request,$id,$date)
    {
        //
        $absent = Absensi::create([
            'id_karyawan' => $id,
            'keterangan' => $request->action,
            'jam_masuk' => Carbon::now()->format('H:i:s'),
            'created_at' => $date,'00:00:00'
        ]);

        Session::flash('success', 'Data Absensi Berhasil Diperbarui');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function test()
    {
        //
        $tanggal = Carbon::parse('14-03-2022')->addDays(30)->format('Y-m-d');
        $absensi = Absensi::whereDate('created_at',$tanggal)->select('foto')->get();

        foreach ($absensi as $a) {
            Storage::disk('public')->delete($a->foto);
        }
    }
     //

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
