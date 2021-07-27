<?php

declare(strict_types=1);

namespace Atk4\Ui\Form\Control;

// @TODO find a better way to load assets

class TextEditor extends Textarea
{
    public $defaultTemplate = __DIR__ . '/../template/trumbowyg.html';

    //public $assets_path = '/assets';
    public $assets_path = 'https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.20.0';
    public $option_resetCss = true;
    public $option_autogrow = true;
    public $editor_options = [
        'btns' => [
            ['viewHTML'],
            ['undo', 'redo'], // Only supported in Blink browsers
            ['formatting'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['link'],
            ['insertImage'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen'],
        ],
        'resetCss' => true,
        'autogrow' => true,
    ];
    public $plugins = [];
    protected $required_js = [
        '/trumbowyg.js',
    ];
    protected $required_css = [
        '/ui/trumbowyg.css',
    ];

    protected function init(): void
    {
        parent::init();

        $this->addRequiredAssets();
        foreach ($this->plugins as $plugin) {
            $this->addRequiredPlugin($plugin);
        }
        //$this->setStyle('display','block');

        $this->editor_options['resetCss'] = $this->option_resetCss;
        $this->editor_options['autogrow'] = $this->option_autogrow;

        $jsInput = $this->jsInput(true);
        $jsInput->trumbowyg($this->editor_options); // @phpstan-ignore-line
        $jsInput->parent()->find('.trumbowyg-editor')->attr('id', $this->short_name . '-editor');
    }

    private function addRequiredAssets(): void
    {
        foreach ($this->required_js as $js) {
            $this->getApp()->requireJS($this->assets_path . $js);
        }

        foreach ($this->required_css as $css) {
            $this->getApp()->requireCSS($this->assets_path . $css);
        }
    }

    private function addRequiredPlugin($plugin_asset): void
    {
        $plugin_asset = $this->assets_path . '/plugins/' . $plugin_asset;

        $this->getApp()->requireJS($plugin_asset);
    }
}
