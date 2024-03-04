<?php

declare(strict_types=1);

namespace Atk4\TextEditor\Demos;

use Atk4\Data\Persistence;
use Atk4\Ui\App;
use Atk4\Ui\Exception;
use PHPUnit\Framework\TestCase;

date_default_timezone_set('UTC');

require_once __DIR__ . '/init-autoloader.php';

// collect coverage for HTTP tests 1/2
if (file_exists(__DIR__ . '/CoverageUtil.php') && !class_exists(TestCase::class, false)) {
    require_once __DIR__ . '/CoverageUtil.php';
    \CoverageUtil::start();
}

$app = new App(['title' => 'ATK4 :: Trumbowyg Demo']);

// collect coverage for HTTP tests 2/2
if (file_exists(__DIR__ . '/CoverageUtil.php') && !class_exists(TestCase::class, false)) {
    $app->onHook(App::HOOK_BEFORE_EXIT, static function () {
        \CoverageUtil::saveData();
    });
}

try {
    /** @var Persistence\Sql $db */
    require_once __DIR__ . '/init-db.php';
    $app->db = $db;
    unset($db);
} catch (\Throwable $e) {
    throw new Exception('Database error: ' . $e->getMessage());
}
