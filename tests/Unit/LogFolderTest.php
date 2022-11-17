<?php

use Zimonh\LogViewer\LogFile;
use Zimonh\LogViewer\LogFolder;

test('LogFolder can get the earliest timestamp of the files it contains', function () {
    $firstFile = Mockery::mock(new LogFile('test.log', 'folder'))
        ->allows(['earliestTimestamp' => now()->subDay()->timestamp]);
    $secondFile = Mockery::mock(new LogFile('test2.log', 'folder'))
        ->allows(['earliestTimestamp' => now()->subDays(2)->timestamp]);
    $folder = new LogFolder('folder', [$firstFile, $secondFile]);

    expect($folder->earliestTimestamp())->toBe($secondFile->earliestTimestamp());
});

test('LogFolder can get the latest timestamp of the files it contains', function () {
    $firstFile = Mockery::mock(new LogFile('test.log', 'folder'))
        ->allows(['latestTimestamp' => now()->subDay()->timestamp]);
    $secondFile = Mockery::mock(new LogFile('test2.log', 'folder'))
        ->allows(['latestTimestamp' => now()->subDays(2)->timestamp]);
    $folder = new LogFolder('folder', [$firstFile, $secondFile]);

    expect($folder->latestTimestamp())->toBe($firstFile->latestTimestamp());
});
