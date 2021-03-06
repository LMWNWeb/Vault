<?php

ob_start();
session_start();
/**
 * @author      LMWN <contact@lmwn.co.uk>
 * @copyright   Copyright (c), 2022 LMWN & Lewis Milburn
 *
 * This file is a modified version of the demo router provided by https://github.com/bramus/router.
 */

const BASE_URI = '/Vault';

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

require_once __DIR__ . '/Boa/Boa.php';

$app = new Boa\App();
$router = new Boa\Router\Router();
$SQL = new Boa\Database\SQL();

// Before Router Middleware
$router->before('GET', '/.*', function () {
    header('Location: /Bonfire/error.php?code=404');
    exit;
});

// Homepage
$router->get('/', function () {
    if (isset($_SESSION['token']) && isset($_SESSION['uuid'])) {
        require_once __DIR__ . '/common/views/homepage.php';
    } else {
        require_once __DIR__ . '/common/views/login.php';
    }
});

// Thunderbirds are go!
$router->run();

// EOF
ob_end_flush();