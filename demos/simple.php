<?php
include '../vendor/autoload.php';

use atk4\ui\App;
use atk4\ui\Form\Control\TextEditor;

$app = new App([
    'title' => 'Agile toolkit WYSIWYG',
    'call_exit' => false
]);
$app->initLayout([\Atk4\Ui\Layout\Centered::class]);

/** @var \atk4\ui\Form $form */
$form = $app->add('Form');
$form->addControl('subject');
$form->addControl('editor', [
    \Atk4\Ui\Form\Control\TextEditor::class,
    'placeholder' => 'test placeholder'
]);

$form->onSubmit(function($f) {
    $view = new \atk4\ui\Message();
    $view->invokeInit();
    $view->text->addParagraph('subject : ' . $f->model->get('subject'));
    $view->text->addParagraph('editor : ' . $f->model->get('editor'));

    return $view;
});

$app->run();