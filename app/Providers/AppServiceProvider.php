<?php

namespace App\Providers;

use App\Events\WasteRecordCreated;
use App\Events\WasteRecordDeleted;
use App\Events\WasteRecordUpdated;
use App\Listeners\UpdateAnnualReportsOnWasteRecordChange;
use App\Listeners\UpdateAnnualReportsOnWasteRecordDeleted;
use App\Listeners\UpdateAnnualReportsOnWasteRecordUpdated;
use App\Listeners\UpdateEvidenceSheetsOnWasteRecordChange;
use App\Listeners\UpdateEvidenceSheetsOnWasteRecordDeleted;
use App\Listeners\UpdateEvidenceSheetsOnWasteRecordUpdated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        WasteRecordCreated::class => [
            UpdateEvidenceSheetsOnWasteRecordChange::class,
            UpdateAnnualReportsOnWasteRecordChange::class,
        ],
        WasteRecordUpdated::class => [
            UpdateEvidenceSheetsOnWasteRecordUpdated::class,
            UpdateAnnualReportsOnWasteRecordUpdated::class,
        ],
        WasteRecordDeleted::class => [
            UpdateEvidenceSheetsOnWasteRecordDeleted::class,
            UpdateAnnualReportsOnWasteRecordDeleted::class,
        ],
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
