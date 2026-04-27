<?php

namespace App\Exports;

use App\Models\Shipment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CostReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $project_id;
    protected $bulan;

    public function __construct($project_id = null, $bulan = 'all')
    {
        $this->project_id = $project_id;
        $this->bulan = $bulan;
    }

    public function collection()
    {
        $query = Shipment::select(
                'expedition',
                \DB::raw('COUNT(*) as total_shipments'),
                \DB::raw('SUM(weight) as total_weight'),
                \DB::raw('SUM(shipping_cost) as total_cost'),
                \DB::raw('AVG(shipping_cost) as avg_cost')
            )
            ->whereNotNull('shipping_cost')
            ->whereNotNull('expedition');

        if ($this->project_id) {
            $query->where('project_id', $this->project_id);
        }

        if ($this->bulan !== 'all') {
            $query->whereMonth('created_at', $this->bulan);
        }

        return $query->groupBy('expedition')->get();
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