<?php

namespace App\Exports;

use App\Models\Shipment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CostReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        return Shipment::select(
                'expedition',
                \DB::raw('COUNT(*) as total_shipments'),
                \DB::raw('SUM(weight) as total_weight'),
                \DB::raw('SUM(shipping_cost) as total_cost'),
                \DB::raw('AVG(shipping_cost) as avg_cost')
            )
            ->whereMonth('created_at', $this->month)
            ->whereYear('created_at', $this->year)
            ->whereNotNull('shipping_cost')
            ->whereNotNull('expedition')
            ->groupBy('expedition')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Ekspedisi',
            'Jumlah Kiriman',
            'Total Berat (kg)',
            'Total Biaya (Rp)',
            'Rata-rata Biaya per Kiriman (Rp)'
        ];
    }

    public function map($row): array
    {
        return [
            $row->expedition,
            $row->total_shipments,
            number_format($row->total_weight, 2),
            $row->total_cost,
            number_format($row->avg_cost, 0, ',', '.')
        ];
    }
}