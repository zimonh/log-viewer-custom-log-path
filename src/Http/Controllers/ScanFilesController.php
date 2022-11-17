<?php

namespace Zimonh\LogViewer\Http\Controllers;

use Zimonh\LogViewer\Facades\LogViewer;
use Zimonh\LogViewer\LogFile;
use Zimonh\LogViewer\LogReader;

class ScanFilesController
{
    public function __invoke()
    {
        $files = LogViewer::getFiles();
        $filesRequiringScans = $files->filter(fn (LogFile $file) => $file->logs()->requiresScan());

        $filesRequiringScans->each(function (LogFile $file) {
            $file->logs()->scan();

            LogReader::clearInstance($file);
        });

        return response()->json([
            'success' => true,
        ]);
    }
}
