<?php

declare(strict_types=1);

include __DIR__ . '/init-app.php';

use Atk4\Ui\App;
use Atk4\Ui\Layout\Centered;

$app = new App([
    'title' => 'Agile toolkit WYSIWYG',
    'call_exit' => false,
]);
$app->initLayout([Centered::class]);

$form = \Atk4\Ui\Form::addTo($app);
$form->addControl('subject');
$form->addControl('editor', [
    \Atk4\Ui\Form\Control\TextEditor::class,
    'placeholder' => 'test placeholder',
]);

$form->onSubmit(function ($f) {
    $view = new \Atk4\Ui\Message();
    $view->invokeInit();
    $view->text->addParagraph('subject : ' . $f->model->get('subject'));
    $view->text->addParagraph('editor : ' . $f->model->get('editor'));

    return $view;
});

$app->run();
