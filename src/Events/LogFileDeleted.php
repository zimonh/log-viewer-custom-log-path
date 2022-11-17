<?php

namespace Zimonh\LogViewer\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Zimonh\LogViewer\LogFile;

class LogFileDeleted
{
    use Dispatchable;

    public function __construct(
        public LogFile $file
    ) {
    }
}
