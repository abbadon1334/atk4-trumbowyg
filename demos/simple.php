<?php
include '../vendor/autoload.php';

use atk4\ui\App;
use atk4\ui\FormField\TextEditor;

$app = new App([
    'title' => 'Agile toolkit WYSIWYG',
    'call_exit' => false
]);
$app->initLayout('Centered');

/** @var \atk4\ui\Form $form */
$form = $app->add('Form');
$form->addField('subject');
$form->addField('editor', [
    new TextEditor(),
    'placeholder' => 'test placeholder'
]);

$form->onSubmit(function($f) {
    $view = new \atk4\ui\Message();
    $view->init();
    $view->text->addParagraph('subject : ' . $f->model->get('subject'));
    $view->text->addParagraph('editor : ' . $f->model->get('editor'));

    return $view;
});

$app->run();