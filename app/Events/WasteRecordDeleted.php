<?php

namespace App\Events;

use App\Models\WasteRecord;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WasteRecordDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $companyId;
    public int $year;
    public string $wasteType;

    /**
     * Create a new event instance.
     */
    public function __construct(int $companyId, int $year, string $wasteType)
    {
        $this->companyId = $companyId;
        $this->year = $year;
        $this->wasteType = $wasteType;
    }
}
