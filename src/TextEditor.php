<?php

declare(strict_types=1);

namespace Atk4\TextEditor;

use Atk4\Ui\Form\Control\Textarea;
use Atk4\Ui\Jquery;

class TextEditor extends Textarea
{
    protected static array $loaded_assets = [];

    //public $assets_path = '/assets';
    public string $assets_path = 'https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1';
    public bool $option_resetCss = true;
    public bool $option_autogrow = true;
    public array $editor_options = [
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

    public array $plugins = [];

    private array $required_js = [
        '/trumbowyg.js',
    ];
    private array $required_css = [
        '/ui/trumbowyg.css',
    ];

    /**
     * Render view.
     */
    protected function renderView(): void
    {
        parent::renderView();

        $this->addRequiredAssets();

        foreach ($this->plugins as $plugin) {
            $this->addRequiredPlugin($plugin);
        }

        $this->editor_options['resetCss'] = $this->option_resetCss;
        $this->editor_options['autogrow'] = $this->option_autogrow;

        $jsInput = $this->jsInput(true);
        $jsInput->trumbowyg($this->editor_options); // @phpstan-ignore-line
    }

    /**
     * Will return jQuery expression to set editor html content.
     *
     * @param string|bool|null $when Event when chain will be executed
     */
    public function jsSetHtml($when = null, string $html = ''): Jquery
    {
        return $this->jsInput($when)->trumbowyg('html', $html); // @phpstan-ignore-line
    }

    /**
     * Will return jQuery expression to get editor html content.
     *
     * @param string|bool|null $when Event when chain will be executed
     */
    public function jsGetHtml($when = null): Jquery
    {
        return $this->jsInput($when)->trumbowyg('html'); // @phpstan-ignore-line
    }

    private function addRequiredAssets(): void
    {
        foreach ($this->required_js as $js) {
            if ($this->isAssetLoaded($js)) {
                continue;
            }

            static::$loaded_assets[] = $js;

            $this->getApp()->requireJs($this->assets_path . $js);
        }

        foreach ($this->required_css as $css) {
            if ($this->isAssetLoaded($css)) {
                continue;
            }

            static::$loaded_assets[] = $css;

            $this->getApp()->requireCss($this->assets_path . $css);
        }
    }

    private function isAssetLoaded(string $asset): bool
    {
        return in_array($asset, self::$loaded_assets, false);
    }

    private function addRequiredPlugin(string $plugin_asset): void
    {
        $plugin_asset = $this->assets_path . '/plugins/' . $plugin_asset;

        if ($this->isAssetLoaded($plugin_asset)) {
            return;
        }

        static::$loaded_assets[] = $plugin_asset;

        $this->getApp()->requireJs($plugin_asset);
    }
}
