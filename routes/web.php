<?php

use App\Http\Controllers\AnnualReportController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\KpoController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WasteController;
use App\Http\Controllers\WasteContractController;
use App\Http\Controllers\WasteRecordController;
use App\Http\Controllers\WasteEvidenceSheetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('companies', CompanyController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('operators', OperatorController::class);
    Route::resource('wastes', WasteController::class);
    Route::resource('kpo', KpoController::class);
    Route::resource('waste-contracts', WasteContractController::class);
    Route::resource('waste-records', WasteRecordController::class);
    Route::resource('waste-evidence-sheets', WasteEvidenceSheetController::class);
    Route::resource('annual-reports', AnnualReportController::class);
    
    Route::get('pickups', [PickupController::class, 'index'])->name('pickups.index');
    Route::get('pickups/{waste}', [PickupController::class, 'show'])->name('pickups.show');
    Route::post('pickups/{waste}/update-status', [PickupController::class, 'updateStatus'])->name('pickups.updateStatus');
    
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/{waste}/pdf', [ReportController::class, 'downloadPdf'])->name('reports.downloadPdf');
    
    Route::get('waste-contracts/{wasteContract}/download', [WasteContractController::class, 'download'])
        ->name('waste-contracts.download')
        ->middleware('signed');
    
    Route::get('waste-evidence-sheets/{id}/pdf', [WasteEvidenceSheetController::class, 'generatePdf'])
        ->name('waste-evidence-sheets.pdf');
    
    Route::post('annual-reports/generate', [AnnualReportController::class, 'generate'])
        ->name('annual-reports.generate');
    Route::get('annual-reports/{id}/pdf', [AnnualReportController::class, 'pdf'])
        ->name('annual-reports.pdf');
});

require __DIR__.'/auth.php';
