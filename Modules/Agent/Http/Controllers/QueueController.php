<?php

namespace Modules\Agent\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class QueueController extends Controller
{
    public function runQueueWork()
    {
        // Run the queue:work command
        Artisan::call('queue:work', [
            '--once'    => true,
            '--timeout' => 10,
            '--tries'   => 3,
        ]);
    }
}
