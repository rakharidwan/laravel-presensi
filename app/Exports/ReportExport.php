<?php

namespace App\Exports;

use App\Models\Absensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;


class ReportExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id;
    protected $from;
    protected $to;
    protected $count_absensi;

    function __construct($id,$from,$to,$count_absensi) {
        $this->id = $id;
        $this->from = $from;
        $this->to = $to;
        $this->$count_absensi = $count_absensi;
    }

    public function view(): View
    {   
        $absensi = Absensi::with(['karyawan.jabatan'])->whereHas('karyawan', function (Builder $query){
            $query->where('karyawans.id',$this->id);
        })->whereBetween('created_at',[$this->from,$this->to])->get();

        if ($this->id = 'all') {
            $absensi = Absensi::with(['karyawan.jabatan'])->whereBetween('created_at',[$this->from,$this->to])->get();
        }

        return view('pages.laporan.export-laporan', [
            'absensi' => $absensi
        ]);
    }

    public function registerEvents(): array
    {   
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->style(
                    [
                        'borders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                                'color' => ['argb' => '00000000'],
                        ]
                    ]
                );
            },
        ];
    }

}
