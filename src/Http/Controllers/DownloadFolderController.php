<?php

namespace Zimonh\LogViewer\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Zimonh\LogViewer\Facades\LogViewer;

class DownloadFolderController
{
    public function __invoke(string $folderIdentifier)
    {
        LogViewer::auth();

        $folder = LogViewer::getFolder($folderIdentifier);

        abort_if(is_null($folder), 404);

        Gate::authorize('downloadLogFolder', $folder);

        return $folder->download();
    }
}
