<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;


class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $karyawan = Karyawan::orderBy('nama','asc')->get();
            $absensi = Absensi::with(['karyawan.jabatan'])->whereHas('karyawan', function (Builder $query){
                $query->where('karyawans.id',request('karyawan'));
            })->whereBetween('created_at',[request('from'),request('to')])->get();

        if (request('karyawan') == 'all') {
            $absensi = Absensi::with(['karyawan.jabatan'])->whereBetween('created_at',[request('from'),request('to')])->get();
        }
        
        return view('pages.laporan.index-laporan',['karyawan' => $karyawan,'absensi' => $absensi]);

    }
                                                    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        //
        if ($request->karyawan == 'all') {

            return Excel::download(new ReportExport($request->karyawan,$request->from,$request->to,$request->count_absensi), 'karyawan_'.$request->from.'_'.$request->to.'.xlsx');
        }

        $karyawan = Karyawan::where('id',$request->karyawan)->first();

        return Excel::download(new ReportExport($request->karyawan,$request->from,$request->to,$request->count_absensi), $karyawan->nama.'_'.$karyawan->nik.'_'.$karyawan->from.'_'.$karyawan->to.'.xlsx');
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
