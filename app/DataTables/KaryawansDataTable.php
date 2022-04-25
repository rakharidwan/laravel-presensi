<?php

namespace App\DataTables;

use App\Models\Karyawan;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KaryawansDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
        ->eloquent($query)
        ->addColumn('action' , function($karyawan){
            $csrf =  csrf_token();
            $btn = '<div class="basic-dropdown">
            <div class="dropdown">
              <button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown">
                Tindakan
              </button>
              <div class="dropdown-menu">
                <button type="button" class="dropdown-item mb-2 edit" data-id="'.$karyawan->id.'" data-toggle="modal" data-target="#modalUbahKaryawan"><i class="bi bi-pencil-square"></i> Ubah</button>
                <form action="/karyawan/hapus/'.$karyawan->id.'" method="POST">
                <input type="hidden" name="_token" value="'.$csrf.'">
                <input type="hidden" name="_method" value="delete" />
                  <button class="dropdown-item" ><i class="bi bi-trash text-danger"></i> Hapus</button>
                </form>
              </div>
            </div>
          </div>';

          return $btn;
        })
        ->addColumn('foto' , function($karyawan){
            $path = public_path();

            if ($karyawan->foto != null) {
                $foto = '<div class="foto-karyawan">
                <img src="'.$path.'/'.$karyawan->foto.'" alt="Foto Karyawan">
              </div>';
            }else {
                $foto = '<i class="bi bi-file-person"></i>';
                
            }
            return $foto;
        })
        ->addColumn('jabatan', function($karyawan){
            return $karyawan->jabatan->jabatan;
        })
        ->rawColumns(['foto','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Karyawan $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Karyawan $model)
    {   
        $karyawan = Karyawan::with(['jabatan'])->orderBy('created_at','desc');
        return $karyawan->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('karyawans-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('nik'),
            Column::make('nama'),
            Column::make('entitas'),
            Column::make('jabatan'),
            Column::make('nomor_hp'),
            Column::computed('foto')
                  ->exportable(false)
                  ->printable(false),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Karyawans_' . date('YmdHis');
    }
}
