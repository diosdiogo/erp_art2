<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Sistema\Produto\Produto;

class ContaPagarEvento extends Event
{
    use SerializesModels;

    protected $produto;
    
    public function __construct(Produto $produto)
    {
        $this->$produto = $produto;
    }

    public function broadcastOn()
    {
        return [];
    }
}
