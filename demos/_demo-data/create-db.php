<?php

declare(strict_types=1);

namespace Atk4\Ui\Demos;

use Atk4\Data\Persistence;
use Atk4\Data\Schema\Migrator;
use Atk4\Ui\Demos\Model\Post;

require_once __DIR__ . '/../init-autoloader.php';

$sqliteFile = __DIR__ . '/db.sqlite';
if (!file_exists($sqliteFile)) {
    new Persistence\Sql('sqlite:' . $sqliteFile);
}
unset($sqliteFile);

/** @var Persistence\Sql $db */
require_once __DIR__ . '/../init-db.php';

echo 'GITHUB_JOB : ' . getenv('GITHUB_JOB') . "\n\n";

(new Migrator(new Post($db)))->create();

echo 'import complete!' . "\n\n";
