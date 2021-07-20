<?php

declare(strict_types=1);

require __DIR__ . '/../init-app.php';

$sqliteFile = __DIR__ . '/db.sqlite';
if (file_exists($sqliteFile)) {
    unlink($sqliteFile);
}

$persistence = new \Atk4\Data\Persistence\Sql('sqlite:' . $sqliteFile);
$model = new \Atk4\Data\Model($persistence, ['table' => 'editor']);
$model->addField('subject', ['type' => 'string']);
$model->addField('editor', ['type' => 'text']);
(new \Atk4\Schema\Migration($model))->dropIfExists()->create();

echo 'import complete!' . "\n";