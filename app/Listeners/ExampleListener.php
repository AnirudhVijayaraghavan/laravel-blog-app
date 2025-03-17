<?php

namespace App\Listeners;

use App\Events\ExampleEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExampleListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ExampleEvent $event): void
    {
        //
        Log::debug("ExampleListener:ExampleEvent called. User-> {$event -> username}, Action-> {$event -> action}");
    }
}
