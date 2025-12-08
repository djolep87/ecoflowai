<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Waste extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'location_id',
        'tip_otpada',
        'kolicina',
        'datum_nastanka',
        'status',
        'napomena',
        'operator_id',
        'datum_preuzimanja',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'datum_nastanka' => 'date',
            'datum_preuzimanja' => 'datetime',
            'kolicina' => 'decimal:2',
        ];
    }

    /**
     * Get the company that owns the waste.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the location that owns the waste.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the operator who picked up the waste.
     */
    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }

    /**
     * Get the KPO entries for the waste.
     */
    public function kpoEntries(): HasMany
    {
        return $this->hasMany(KpoEntry::class);
    }
}

