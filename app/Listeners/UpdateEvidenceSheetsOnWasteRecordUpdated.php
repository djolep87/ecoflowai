<?php

namespace App\Listeners;

use App\Events\WasteRecordUpdated;
use App\Models\WasteEvidenceSheet;
use App\Models\WasteRecord;

class UpdateEvidenceSheetsOnWasteRecordUpdated
{
    /**
     * Handle the event.
     */
    public function handle(WasteRecordUpdated $event): void
    {
        $wasteRecord = $event->wasteRecord;
        $year = $wasteRecord->datum_nastanka->year;
        $wasteType = $wasteRecord->waste_type;

        // Get all waste records for this company, year, and waste type
        $totalQuantity = WasteRecord::where('company_id', $wasteRecord->company_id)
            ->whereYear('datum_nastanka', $year)
            ->where('waste_type', $wasteType)
            ->sum('kolicina');

        // Get the unit from the waste record
        $unit = $wasteRecord->jedinica_mere;

        // Update or create evidence sheet
        WasteEvidenceSheet::updateOrCreate(
            [
                'company_id' => $wasteRecord->company_id,
                'godina' => $year,
                'waste_type' => $wasteType,
            ],
            [
                'ukupna_kolicina' => $totalQuantity,
                'jedinica_mere' => $unit,
                'opis' => 'Automatski ažurirano iz evidencije otpada',
            ]
        );
    }
}
