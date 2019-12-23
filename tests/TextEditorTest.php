<?php

namespace atk4\ui\FormField;


use atk4\ui\App;
use atk4\ui\Layout\Centered;
use PHPUnit_Framework_TestCase;

class TextEditorTest extends PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        $app = new App([
            'call_exit' => false
        ]);
        $app->initLayout(Centered::class);
        $form = $app->add('Form');
        $form->addField('subject');
        $form->addField('editor', [
            new TextEditor(),
            'placeholder' => 'test placeholder'
        ]);
        ob_start();
        $app->run();
        $rendered = ob_get_clean();

        $this->assertNotFalse(strpos($rendered, 'trumbowyg'));
    }


    public function testInitFQCN()
    {
        $app = new App([
            'call_exit' => false
        ]);
        $app->initLayout(Centered::class);
        $form = $app->add('Form');
        $form->addField('subject');
        $form->addField('editor', [
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
        $app->initLayout(Centered::class);
        $form = $app->add('Form');
        $form->addField('subject');
        $form->addField('editor', [
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
