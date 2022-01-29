<?php

declare(strict_types=1);

namespace Atk4\Ui\Demos;

use Atk4\Ui\Demos\Model\Post;
use Atk4\Ui\Layout\Centered;

date_default_timezone_set('UTC');

require_once __DIR__ . '/../vendor/autoload.php';

/** @var \Atk4\Ui\App $app */
require __DIR__ . '/init-app.php';

$app->initLayout([Centered::class]);

$form = \Atk4\Ui\Form::addTo($app);
$form->setModel((new Post($app->db))->createEntity(), []);

$form->addControl('subject');
$form->addControl('body', [
    \Atk4\Ui\Form\Control\TextEditor::class,
    'placeholder' => 'test placeholder',
]);

$form->onSubmit(function ($f) {
    $view = new \Atk4\Ui\Message();
    $view->invokeInit();
    $view->text->addParagraph('subject : ' . $f->model->get('subject'));
    $view->text->addParagraph('body : ' . $f->model->get('body'));

    return $view;
});

$app->run();
