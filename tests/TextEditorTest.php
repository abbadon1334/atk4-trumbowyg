<?php

declare(strict_types=1);

namespace TextEditor\Tests;

use Atk4\Core\AtkPhpunit;
use Atk4\Ui\App;
use Atk4\Ui\Form;
use Atk4\Ui\Form\Control\TextEditor;
use Atk4\Ui\Layout\Centered;

class TextEditorTest extends AtkPhpunit\TestCase
{
    public function testInit()
    {
        $app = new AppFormTestMock([
            'catch_exceptions' => false,
            'always_run' => false,
            'catch_runaway_callbacks' => false,
            'call_exit' => false,
        ]);
        $app->initLayout([Centered::class]);
        $form = Form::addTo($app);
        $form->addControl('subject');
        $form->addControl('editor', [
            TextEditor::class,
            'placeholder' => 'test placeholder',
        ]);
        $app->run();

        $this->assertGreaterThan(0, preg_match('/trumbowyg/', $app->output));
    }

    public function testPlugin()
    {
        $app = new AppFormTestMock([
            'always_run' => false,
            'call_exit' => false,
        ]);
        $app->initLayout([Centered::class]);
        $form = Form::addTo($app);
        $form->addControl('subject');
        $form->addControl('editor', [
            TextEditor::class,
            'placeholder' => 'test placeholder',
            'plugins' => [
                'base64',
            ],
        ]);
        $app->run();

        $this->assertGreaterThan(0, preg_match('/base64/', $app->output));
    }
}

class AppFormTestMock extends App
{
    public $output;

    protected function outputResponse(string $data, array $headers): void
    {
        $this->output = $data;
    }
}
