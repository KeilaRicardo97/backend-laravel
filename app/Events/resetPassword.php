<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\User;
class resetPassword
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

   public $datos;
    public function __construct($datos)
    {
        $this->datos = $datos;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
