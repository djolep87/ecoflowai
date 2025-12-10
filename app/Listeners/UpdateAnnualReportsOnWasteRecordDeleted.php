<?php

namespace App\Listeners;

use App\Events\WasteRecordDeleted;
use App\Models\AnnualReport;
use App\Models\WasteRecord;
use App\Services\AnnualReportService;

class UpdateAnnualReportsOnWasteRecordDeleted
{
    protected AnnualReportService $reportService;

    public function __construct(AnnualReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Handle the event.
     */
    public function handle(WasteRecordDeleted $event): void
    {
        // Check if annual report exists for this company and year
        $annualReport = AnnualReport::where('company_id', $event->companyId)
            ->where('godina', $event->year)
            ->first();

        if ($annualReport) {
            // Regenerate report data
            $reportData = $this->reportService->generateReportData(
                $event->companyId,
                $event->year
            );

            // Update the annual report
            $annualReport->update([
                'ukupno_kolicina' => $reportData['ukupno_kolicina'],
                'broj_vrsta_otpada' => $reportData['broj_vrsta_otpada'],
            ]);
        }
    }
}
