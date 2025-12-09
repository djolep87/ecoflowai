<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnualReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'godina',
        'ukupno_kolicina',
        'broj_vrsta_otpada',
        'napomena',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'godina' => 'integer',
        'ukupno_kolicina' => 'decimal:2',
        'broj_vrsta_otpada' => 'integer',
    ];

    /**
     * Get the company that owns the annual report.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}

