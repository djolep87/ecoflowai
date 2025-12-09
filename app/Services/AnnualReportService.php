<?php

namespace App\Services;

use App\Models\WasteRecord;
use Illuminate\Support\Collection;

class AnnualReportService
{
    /**
     * Generate annual report data for a company and year.
     *
     * @param int $companyId
     * @param int $year
     * @return array
     */
    public function generateReportData(int $companyId, int $year): array
    {
        // Get all waste records for the company in the specified year
        $wasteRecords = WasteRecord::where('company_id', $companyId)
            ->whereYear('datum_nastanka', $year)
            ->get();

        // Calculate total quantity (convert all to same unit if needed, or sum as is)
        $ukupnoKolicina = $wasteRecords->sum('kolicina');

        // Get unique waste types count
        $brojVrstaOtpada = $wasteRecords->pluck('waste_type')->unique()->count();

        // Group by waste type for detailed breakdown
        $wasteByType = $wasteRecords->groupBy('waste_type')->map(function ($records) {
            return [
                'total' => $records->sum('kolicina'),
                'unit' => $records->first()->jedinica_mere ?? 'kg',
                'count' => $records->count(),
            ];
        });

        return [
            'company_id' => $companyId,
            'godina' => $year,
            'ukupno_kolicina' => $ukupnoKolicina,
            'broj_vrsta_otpada' => $brojVrstaOtpada,
            'waste_by_type' => $wasteByType,
            'total_records' => $wasteRecords->count(),
            'waste_records' => $wasteRecords,
        ];
    }

    /**
     * Get waste records grouped by type for PDF display.
     *
     * @param int $companyId
     * @param int $year
     * @return Collection
     */
    public function getWasteByType(int $companyId, int $year): Collection
    {
        $wasteRecords = WasteRecord::where('company_id', $companyId)
            ->whereYear('datum_nastanka', $year)
            ->get();

        return $wasteRecords->groupBy('waste_type')->map(function ($records, $type) {
            return [
                'type' => $type,
                'total' => $records->sum('kolicina'),
                'unit' => $records->first()->jedinica_mere ?? 'kg',
                'count' => $records->count(),
            ];
        })->values();
    }
}

