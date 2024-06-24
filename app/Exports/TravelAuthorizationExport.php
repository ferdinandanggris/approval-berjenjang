<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TravelAuthorizationExport implements FromCollection, WithEvents,WithStyles,WithStartRow,WithHeadings
{
    private $travelAuthorization;
    public function __construct($travelAuthorization)
    {
        $this->travelAuthorization = $travelAuthorization;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->travelAuthorization->map(function($data){
            return [
                $data->id,
                $data->user->name,
                $data->start_date,
                $data->end_date,
                $data->reason,
                $data->status,
                $data->created_at,
                $data->updated_at
            ];
        });
    }

    public function startRow(): int
    {
        return 2;
    }

    public function headings(): array
    {
        return [
            'ID',
            'User',
            'Start Date',
            'End Date',
            'Reason',
            'Status',
            'Created At',
            'Updated At'
        ];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:H1')->applyFromArray([
                    'font' => [
                        'bold' => true
                        ]
                    ]);
            }
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $last_column = $sheet->getHighestColumn();
        // autosize 
        foreach(range('A',$last_column) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    }
}
