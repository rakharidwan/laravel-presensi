<?php

namespace App\DataTables;

use App\Models\Jabatan;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class JabatansDataTable extends DataTable
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
            ->addColumn('tanggal_input',function($jabatan){
                return $jabatan->created_at;
            })
            ->addColumn('action',function($jabatan){
                $csrf =  csrf_token();
            $btn = '<div class="basic-dropdown">
            <div class="dropdown">
              <button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown">
                Tindakan
              </button>
              <div class="dropdown-menu">
                <button type="button" class="dropdown-item mb-2 edit" data-toggle="modal" data-target="#modalUbahJabatan" data-id="'.$jabatan->id.'"><i class="bi bi-pencil-square"></i> Ubah</button>
                <form action="/jabatan/hapus/'.$jabatan->id.'" method="POST">
                <input type="hidden" name="_token" value="'.$csrf.'">
                <input type="hidden" name="_method" value="delete" />
                  <button class="dropdown-item" ><i class="bi bi-trash text-danger"></i> Hapus</button>
                </form>
              </div>
            </div>
          </div>';
                return $btn;
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Jabatan $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Jabatan $model)
    {   
        $jabatan = Jabatan::orderBy('created_at','desc');
        return $jabatan->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('jabatans-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('jabatan'),
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
        return 'Jabatans_' . date('YmdHis');
    }
}
