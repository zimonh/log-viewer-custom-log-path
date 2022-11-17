<?php

use Zimonh\LogViewer\Facades\LogViewer;
use Zimonh\LogViewer\LogFile;
use Zimonh\LogViewer\LogFileCollection;
use Zimonh\LogViewer\LogFolder;

test('LogViewer::getFiles() returns a LogFileCollection', function () {
    expect(LogViewer::getFiles())->toBeInstanceOf(LogFileCollection::class);
});

test('LogFileCollection can sort its files by earliest logs first', function () {
    $firstFile = Mockery::mock(new LogFile('test.log', 'test.log'))
        ->allows(['earliestTimestamp' => now()->subDay()->timestamp]);
    $secondFile = Mockery::mock(new LogFile('test2.log', 'test2.log'))
        ->allows(['earliestTimestamp' => now()->subDays(2)->timestamp]);
    $collection = new LogFileCollection([$firstFile, $secondFile]);

    $collection->sortByEarliestFirst();

    expect($collection[0])->toBe($secondFile)
        ->and($collection[1])->toBe($firstFile);
});

test('LogFileCollection can sort its files by latest logs first', function () {
    $firstFile = Mockery::mock(new LogFile('test.log', 'test.log'))
        ->allows(['latestTimestamp' => now()->subDays(2)->timestamp]);
    $secondFile = Mockery::mock(new LogFile('test2.log', 'test2.log'))
        ->allows(['latestTimestamp' => now()->subDay()->timestamp]);
    $collection = new LogFileCollection([$firstFile, $secondFile]);

    $collection->sortByLatestFirst();

    expect($collection[0])->toBe($secondFile)
        ->and($collection[1])->toBe($firstFile);
});

test('LogFolder::files() returns a LogFileCollection', function () {
    $folder = new LogFolder(storage_path('subfolder'), []);

    expect($folder->files())->toBeInstanceOf(LogFileCollection::class);
});

test('LogFileCollection can return the latest log file', function () {
    $firstFile = Mockery::mock(new LogFile('test.log', 'test.log'))
        ->allows(['latestTimestamp' => now()->subDays(2)->timestamp]);
    $secondFile = Mockery::mock(new LogFile('test2.log', 'test2.log'))
        ->allows(['latestTimestamp' => now()->subDay()->timestamp]);
    $collection = new LogFileCollection([$firstFile, $secondFile]);

    $logFile = $collection->latest();

    expect($logFile)->toBe($secondFile);
});

test('LogFileCollection can return the earliest log file', function () {
    $firstFile = Mockery::mock(new LogFile('test.log', 'test.log'))
        ->allows(['earliestTimestamp' => now()->subDay()->timestamp]);
    $secondFile = Mockery::mock(new LogFile('test2.log', 'test2.log'))
        ->allows(['earliestTimestamp' => now()->subDays(2)->timestamp]);
    $collection = new LogFileCollection([$firstFile, $secondFile]);

    $logFile = $collection->earliest();

    expect($logFile)->toBe($secondFile);
});
