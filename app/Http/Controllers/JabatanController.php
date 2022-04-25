<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Session;
use App\DataTables\JabatansDataTable;
use Intervention\Image\ImageManager as Image;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(JabatansDataTable $dataTable)
    {
        //
        // $jabatan = Jabatan::orderBy('created_at','desc')->get();

        return $dataTable->render('pages.jabatan.index-jabatan');
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
            'jabatan' => ['required','unique:jabatans,jabatan'],
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 0,'error'=>$validated->errors()]);
        }

        $jabatan = Jabatan::create([
            'jabatan' => $request->jabatan
        ]);

        Session::flash('success', 'Data Jabatan Berhasil Ditambahkan'); 

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
        $jabatan = Jabatan::find($id);
        
        return response(['jabatan' => $jabatan]);
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
            'jabatan' => ['required','unique:jabatans,jabatan,'.$id],
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 0,'error'=>$validated->errors()]);
        }

        $jabatan = Jabatan::where('id',$id)->update([
            'jabatan' => $request->jabatan
        ]);

        Session::flash('success', 'Data Jabatan Berhasil Diubah'); 

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
        $jabatan = Jabatan::find($id);
        $jabatan->delete();

        Session::flash('danger', 'Data Jabatan Berhasil Dihapus'); 

        return redirect()->back();
    }
}
