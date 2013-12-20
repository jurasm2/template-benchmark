<?php

    $loader = require '../vendor/autoload.php';
    $configurator = new Nette\Configurator;

    // Enable Nette Debugger for error visualisation & logging
    //$configurator->setDebugMode(TRUE);
    $configurator->enableDebugger(__DIR__ . '/../log');

    // Specify folder for cache
    $configurator->setTempDirectory(__DIR__ . '/../temp');

    // Enable RobotLoader - this will load all classes automatically
    $configurator->createRobotLoader()
            ->addDirectory(__DIR__.'/../benchmark/')
            ->addDirectory(__DIR__.'/../plugins/')
            ->register();

    $benchmark = new \Benchmark(dirname(__DIR__));
    $selectedEngine = isset($_GET['engine']) ? $_GET['engine'] : null;

    if ($selectedEngine !== null) {
        $benchmark->run($selectedEngine);
    } else {
        $benchmark->renderTitlePage();
    }