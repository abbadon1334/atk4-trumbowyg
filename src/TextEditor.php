<?php

namespace atk4\ui\FormField;

// @TODO find a better way to load assets
// @TODO add realpath security check

class TextEditor extends TextArea
{
    public $defaultTemplate = __DIR__ . '/../template/trumbowyg.html';

    private static $loaded_assets = [];

    //public $assets_path = '/assets';
    public $assets_path = "https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.20.0";

    protected $required_js = [
        '/trumbowyg.js',
    ];

    protected $required_css = [
        '/ui/trumbowyg.css',
    ];

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
            ['fullscreen']
        ],
        'resetCss' => true,
        'autogrow' => true
    ];

    public $plugins = [];

    public function init()
    {
        parent::init();

        $this->addRequiredAssets();
        foreach($this->plugins as $plugin)
        {
            $this->addRequiredPlugin($plugin);
        }
        //$this->setStyle('display','block');

        $this->editor_options['resetCss'] = $this->option_resetCss;
        $this->editor_options['autogrow'] = $this->option_autogrow;

        $this->jsInput(true)->trumbowyg($this->editor_options);
        $this->jsInput(true)->parent()->find('.trumbowyg-editor')->attr('id', $this->short_name.'-editor');
    }

    private function addRequiredAssets() :void
    {
        foreach ($this->required_js as $js) {

            if($this->isAssetLoaded($js)) {
                continue;
            }

            self::$loaded_assets[] = $js;

            $this->app->requireJS($this->assets_path . $js);
        }

        foreach ($this->required_css as $css) {

            if($this->isAssetLoaded($css)) {
                continue;
            }

            self::$loaded_assets[] = $css;

            $this->app->requireCSS($this->assets_path . $css);
        }
    }

    private function isAssetLoaded($asset) :bool
    {
        return in_array($asset,self::$loaded_assets, false);
    }

    private function addRequiredPlugin($plugin_asset) :void
    {
        $plugin_asset = $this->assets_path . '/plugins/'.$plugin_asset;

        if($this->isAssetLoaded($plugin_asset)) {
            return;
        }

        self::$loaded_assets[] = $plugin_asset;

        $this->app->requireJS($plugin_asset);
    }
}