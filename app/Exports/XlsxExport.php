<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class XlsxExport implements FromCollection, WithEvents, WithHeadings, WithStyles
{
    use Exportable;

    public function __construct(
        protected Collection $data,
        protected array $headings,
        protected array $unLockColumns = [],
        protected array $style = [1 => ['font' => ['bold' => true]]]
    ) {
    }

    public function collection(): Collection
    {
        return $this->data;
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function styles(Worksheet $sheet)
    {
        return $this->style;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Apply general styling
                $sheet->getStyle($sheet->calculateWorksheetDimension())->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                        'wrapText' => true,
                    ],
                ]);

                // Set column widths for statements
                foreach (range('A', $sheet->getHighestColumn()) as $columnID) {
                    if ($columnID === 'B') {
                        $sheet->getColumnDimension($columnID)->setWidth(30);
                    } else {
                        $sheet->getColumnDimension($columnID)->setAutoSize(true);
                    }
                }

                // Handle unlock columns
                if (! empty($this->unLockColumns)) {
                    foreach ($this->unLockColumns as $column) {
                        $sheet->getStyle($column.'2:'.$column.$sheet->getHighestRow())
                            ->getProtection()
                            ->setLocked(Protection::PROTECTION_UNPROTECTED);

                        $sheet->getStyle($column.'1')
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('005A9E');

                        $sheet->getStyle($column.'1')
                            ->getFont()
                            ->getColor()
                            ->setARGB('FFFFFF');
                    }
                    $sheet->getProtection()->setSelectLockedCells(true);
                    $sheet->getProtection()->setSheet(true);
                }
            },
        ];
    }
}
