<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Filesystem\Events\FileUploaded;

class FixFilePermissions
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
    public function handle(object $event): void
    {
        // Get the full path to the file
        $path = storage_path('app/' . $event->path);

        // Check if the file exists and update its permissions
        if (file_exists($path)) {
            chmod($path, 0775);
        }
    }
}
