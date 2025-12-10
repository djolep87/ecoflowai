<?php

namespace App\Events;

use App\Models\WasteRecord;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WasteRecordCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public WasteRecord $wasteRecord;

    /**
     * Create a new event instance.
     */
    public function __construct(WasteRecord $wasteRecord)
    {
        $this->wasteRecord = $wasteRecord;
    }
}
