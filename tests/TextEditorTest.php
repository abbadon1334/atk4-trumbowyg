<?php

declare(strict_types=1);

namespace Atk4\TextEditor\Tests;

use Atk4\Data\Schema\TestCase;
use Atk4\Ui\App;
use Atk4\Ui\Form;
use Atk4\TextEditor\TextEditor;
use Atk4\Ui\Layout\Centered;

class TextEditorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $reflectedClass = new \ReflectionClass(TextEditor::class);
        $reflectedClass->setStaticPropertyValue('loaded_assets', []);
    }

    public function testInit(): void
    {
        ob_start();
        try {
            $app = $this->getApp();

            $app->initLayout([Centered::class]);

            $form = Form::addTo($app);
            $form->addControl('subject');
            $form->addControl('editor', [
                TextEditor::class,
                'placeholder' => 'test placeholder',
            ]);
            $app->run();
        } finally {
            $output = ob_get_clean();
        }

        $this->assertSame(1, substr_count($output, '/libs/Trumbowyg/2.20.0/trumbowyg.js'));
    }

    public function testCheckDouble(): void
    {
        ob_start();
        try {
            $app = $this->getApp();

            $app->initLayout([Centered::class]);

            $form = Form::addTo($app);
            $form->addControl('subject');
            $form->addControl('editor', [
                TextEditor::class,
                'placeholder' => 'test placeholder',
            ]);
            $form->addControl('editor2', [
                TextEditor::class,
                'placeholder' => 'test placeholder',
            ]);
            $app->run();
        } finally {
            $output = ob_get_clean();
        }

        $this->assertSame(1, substr_count($output, '/libs/Trumbowyg/2.20.0/trumbowyg.js'));
    }

    public function testPlugin(): void
    {
        ob_start();
        try {
            $app = $this->getApp();

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
        } finally {
            $output = ob_get_clean();
        }

        $this->assertStringContainsString('plugins/base64', $output);
    }

    private function getApp(): App
    {
        return new App([
            'catch_exceptions' => false,
            'always_run' => false,
            'catch_runaway_callbacks' => false,
            'call_exit' => false,
        ]);
    }
}

class AppFormTestMock extends App
{
    public string $output;

    protected function outputResponse(string $data, array $headers): void
    {
        $this->output = $data;
    }
}
