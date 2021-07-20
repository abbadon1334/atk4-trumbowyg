<?php

namespace TextEditor\Tests;


use Atk4\Ui\App;
use Atk4\Ui\Form;
use Atk4\Ui\Form\Control\TextEditor;
use Atk4\Ui\Layout\Centered;
use Atk4\Core\AtkPhpunit;

class TextEditorTest extends AtkPhpunit\TestCase
{
    public function testInit()
    {
        $app = new App([
            'call_exit' => false
        ]);
        $app->initLayout([Centered::class]);
        $form = Form::addTo($app);
        $form->addControl('subject');
        $form->addControl('editor', [
            TextEditor::class,
            'placeholder' => 'test placeholder'
        ]);
        ob_start();
        $app->run();
        $rendered = ob_get_clean();

        $this->assertNotFalse(strpos($rendered, 'trumbowyg'));
    }

    public function testPlugin()
    {
        $app = new App([
            'call_exit' => false
        ]);
        $app->initLayout([Centered::class]);
        $form = Form::addTo($app);
        $form->addControl('subject');
        $form->addControl('editor', [
            TextEditor::class,
            'placeholder' => 'test placeholder',
            'plugins' => [
                'base64'
            ]
        ]);
        ob_start();
        $app->run();
        $rendered = ob_get_clean();

        $this->assertNotFalse(strpos($rendered, 'base64'));
    }
}
