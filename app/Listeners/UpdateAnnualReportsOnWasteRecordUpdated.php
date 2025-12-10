<?php

namespace App\Listeners;

use App\Events\WasteRecordUpdated;
use App\Models\AnnualReport;
use App\Services\AnnualReportService;

class UpdateAnnualReportsOnWasteRecordUpdated
{
    protected AnnualReportService $reportService;

    public function __construct(AnnualReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Handle the event.
     */
    public function handle(WasteRecordUpdated $event): void
    {
        $wasteRecord = $event->wasteRecord;
        $year = $wasteRecord->datum_nastanka->year;

        // Check if annual report exists for this company and year
        $annualReport = AnnualReport::where('company_id', $wasteRecord->company_id)
            ->where('godina', $year)
            ->first();

        if ($annualReport) {
            // Regenerate report data
            $reportData = $this->reportService->generateReportData(
                $wasteRecord->company_id,
                $year
            );

            // Update the annual report
            $annualReport->update([
                'ukupno_kolicina' => $reportData['ukupno_kolicina'],
                'broj_vrsta_otpada' => $reportData['broj_vrsta_otpada'],
            ]);
        }
    }
}
