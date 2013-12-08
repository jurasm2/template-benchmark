<?php
    require '../vendor/autoload.php';
    require '../benchmark/Benchmark.php';

    Nette\Diagnostics\Debugger::enable();
    $benchmark = new Benchmark(dirname(__DIR__));
    $selectedEngine = isset($_GET['engine']) ? $_GET['engine'] : null;

    if ($selectedEngine !== null) {
        $benchmark->run($selectedEngine);
    } else {
        $benchmark->renderTitlePage();
    }