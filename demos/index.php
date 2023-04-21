<?php

declare(strict_types=1);

namespace Atk4\TextEditor\Demos;

use Atk4\TextEditor\Demos\Model\Post;
use Atk4\TextEditor\TextEditor;
use Atk4\Ui\Button;
use Atk4\Ui\Form;
use Atk4\Ui\Form\Control\Input;
use Atk4\Ui\Layout\Centered;
use Atk4\Ui\Message;

date_default_timezone_set('UTC');

require_once __DIR__ . '/../vendor/autoload.php';

/** @var \Atk4\Ui\App $app */
require __DIR__ . '/init-app.php';

$app->initLayout([Centered::class]);

$form = Form::addTo($app);
$form->setModel((new Post($app->db))->createEntity(), []);

$form->addControl('subject');
$form->addControl('body', [
    TextEditor::class,
    'placeholder' => 'test placeholder',
]);

$form->onSubmit(function ($f) {
    $view = new Message();
    $view->setApp($f->getApp());
    $view->invokeInit();
    $view->text->addParagraph('subject : ' . $f->model->get('subject'));
    $view->text->addParagraph('body : ' . $f->model->get('body'));

    return $view;
});

/** @var Input $input */
$input = $form->getControl('subject');

/** @var TextEditor $editor */
$editor = $form->getControl('body');

Button::addTo($app, ['set editor content with random value'])->on('click', function ($jq) use ($editor) {
    return $editor->jsSetHtml(true, (string) random_int(0, 10000));
});

Button::addTo($app, ['get editor content'])->on('click', function ($jq, $content) {
    return $content;
}, [$editor->jsGetHtml()]);

Button::addTo($app, ['refresh editor'])->on('click', function ($jq) use ($editor) {
    return $editor->jsReload();
});

Button::addTo($app, ['refresh input'])->on('click', function ($jq) use ($input) {
    return $input->jsReload();
});
