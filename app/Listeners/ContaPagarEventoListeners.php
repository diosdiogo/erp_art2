<?php

namespace App\Listeners;

use App\Events\ContaPagarEvento;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContaPagarEventoListeners
{
    public function __construct()
    {
        //
    }

    public function handle(ContaPagarEvento $event)
    {
        //
    }
}
