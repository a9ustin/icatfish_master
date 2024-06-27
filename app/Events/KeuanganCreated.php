<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Keuangan;

class KeuanganCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $keuangan; // Properti keuangan

    /**
     * Create a new event instance.
     *
     * @param  Keuangan  $keuangan
     * @return void
     */
    public function __construct(Keuangan $keuangan)
    {
        $this->keuangan = $keuangan;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}