<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operator extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'broj_dozvole',
        'kategorija_dozvole',
        'adresa',
        'kontakt_osoba',
        'telefon',
        'email',
        'status',
    ];

    /**
     * Get the wastes for the operator.
     */
    public function wastes(): HasMany
    {
        return $this->hasMany(Waste::class);
    }
}

