<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WasteEvidenceSheet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'waste_type',
        'godina',
        'ukupna_kolicina',
        'jedinica_mere',
        'opis',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'godina' => 'integer',
        'ukupna_kolicina' => 'decimal:2',
    ];

    /**
     * Get the company that owns the evidence sheet.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}

