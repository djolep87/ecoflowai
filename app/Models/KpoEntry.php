<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KpoEntry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'waste_id',
        'datum',
        'kolicina',
        'nacin_postupanja',
        'opis',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'datum' => 'date',
            'kolicina' => 'decimal:2',
        ];
    }

    /**
     * Get the waste that owns the KPO entry.
     */
    public function waste(): BelongsTo
    {
        return $this->belongsTo(Waste::class);
    }
}

