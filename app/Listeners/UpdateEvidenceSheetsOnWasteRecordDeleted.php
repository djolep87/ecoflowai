<?php

namespace App\Listeners;

use App\Events\WasteRecordDeleted;
use App\Models\WasteEvidenceSheet;
use App\Models\WasteRecord;

class UpdateEvidenceSheetsOnWasteRecordDeleted
{
    /**
     * Handle the event.
     */
    public function handle(WasteRecordDeleted $event): void
    {
        // Get all remaining waste records for this company, year, and waste type
        $totalQuantity = WasteRecord::where('company_id', $event->companyId)
            ->whereYear('datum_nastanka', $event->year)
            ->where('waste_type', $event->wasteType)
            ->sum('kolicina');

        if ($totalQuantity > 0) {
            // Update evidence sheet with new total
            $evidenceSheet = WasteEvidenceSheet::where('company_id', $event->companyId)
                ->where('godina', $event->year)
                ->where('waste_type', $event->wasteType)
                ->first();

            if ($evidenceSheet) {
                $evidenceSheet->update([
                    'ukupna_kolicina' => $totalQuantity,
                    'opis' => 'Automatski ažurirano iz evidencije otpada',
                ]);
            }
        } else {
            // If no records left, optionally delete the evidence sheet
            // Or keep it with 0 quantity - we'll keep it for now
            WasteEvidenceSheet::where('company_id', $event->companyId)
                ->where('godina', $event->year)
                ->where('waste_type', $event->wasteType)
                ->update([
                    'ukupna_kolicina' => 0,
                    'opis' => 'Automatski ažurirano - nema više zapisa',
                ]);
        }
    }
}
