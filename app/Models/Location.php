<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'naziv',
        'adresa',
        'tip',
        'kontakt_osoba',
        'telefon',
        'status',
    ];

    /**
     * Get the company that owns the location.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
