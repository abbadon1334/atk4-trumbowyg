<?php
include '../vendor/autoload.php';

use atk4\ui\App;
use atk4\ui\FormField\TextEditor;

$app = new App(['title' => 'Agile toolkit WYSIWYG']);
$app->initLayout('Centered');
$form = $app->add('Form');
$form->addField('editor', [
    new TextEditor(),
    'placeholder' => 'test placeholder'
]);