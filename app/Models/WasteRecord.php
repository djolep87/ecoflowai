<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WasteRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'operator_id',
        'waste_type',
        'kolicina',
        'jedinica_mere',
        'opis',
        'datum_nastanka',
        'datum_predaje',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'datum_nastanka' => 'date',
        'datum_predaje' => 'date',
        'kolicina' => 'decimal:2',
    ];

    /**
     * Get the company that owns the waste record.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the operator that handles the waste record.
     */
    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }
}

