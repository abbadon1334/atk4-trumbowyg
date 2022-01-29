<?php

declare(strict_types=1);

namespace Atk4\Ui\Demos;

use TextEditor\Tests\TextEditorTest;

$isRootProject = file_exists(__DIR__ . '/../vendor/autoload.php');
/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require dirname(__DIR__, $isRootProject ? 1 : 4) . '/vendor/autoload.php';
if (!$isRootProject && !class_exists(TextEditorTest::class)) {
    throw new \Error('Demos can be run only if atk4/login is a root composer project or if dev files are autoloaded');
}
$loader->setClassMapAuthoritative(false);
$loader->setPsr4('Atk4\Ui\Demos\\', __DIR__ . '/_includes');
unset($isRootProject, $loader);
