<?php

declare(strict_types=1);

namespace Atk4\TextEditor\Tests;

use Atk4\Data\Schema\TestCase;
use Atk4\TextEditor\TextEditor;
use Atk4\Ui\App;
use Atk4\Ui\Form;
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
        $app = $this->getApp();
        $app->initLayout([Centered::class]);

        $form = Form::addTo($app);
        $form->addControl('subject');
        $form->addControl('editor', [
            TextEditor::class,
            'placeholder' => 'test placeholder',
        ]);
        $app->run();

        $this->assertSame(1, substr_count($app->output, (new TextEditor())->assets_path . '/trumbowyg.js'));
        $this->assertSame(1, substr_count($app->output, (new TextEditor())->assets_path . '/ui/trumbowyg.css'));
    }

    public function testCheckDouble(): void
    {
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

        $this->assertSame(1, substr_count($app->output, (new TextEditor())->assets_path . '/trumbowyg.js'));
        $this->assertSame(1, substr_count($app->output, (new TextEditor())->assets_path . '/ui/trumbowyg.css'));
    }

    public function testPlugin(): void
    {
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

        $this->assertStringContainsString('plugins/base64', $app->output);
    }

    private function getApp(): AppFormTestMock
    {
        $_SERVER['REQUEST_URI'] = '/';

        return new AppFormTestMock([
            'catchExceptions' => false,
            'alwaysRun' => false,
            'catchRunawayCallbacks' => false,
            'callExit' => false,
        ]);
    }
}

class AppFormTestMock extends App
{
    public string $output;

    protected function outputResponse(string $data): void
    {
        $this->output = $data;
    }
}
