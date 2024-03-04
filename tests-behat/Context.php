<?php

declare(strict_types=1);

namespace Atk4\TextEditor\Behat;

class Context extends \Atk4\Ui\Behat\Context
{
    /**
     * @When I type in editor :name with text :text
     */
    public function iTypeInEditor(string $name, string $text): void
    {
        $this->getSession()->executeScript("$('textarea[name=" . $name . "]').trumbowyg('html', '" . $text . "')");
    }

    /**
     * @Then Modal is open with raw text :arg1
     * @Then Modal is open with raw text :arg1 in tag :arg2
     *
     * Check if text is present in modal or dynamic modal.
     */
    public function modalIsOpenWithRawText(string $text, string $tag = 'div'): void
    {
        $html = $this->findElement(null, '.modal.visible.active.front')->getHtml();

        if (empty($html)) {
            throw new \Exception('Modal html is empty');
        }

        if (strpos($html, $text) === false) {
            throw new \Exception('Text not found, found : ' . $html);
        }
    }

    /**
     * @Then /^Editor "([^"]*)" value should be equal to "([^"]*)"$/
     */
    public function editorValueShouldBeEqualTo(string $name, string $excepted): void
    {
        $value = $this->getSession()->evaluateScript("$('textarea[name=" . $name . "]').trumbowyg('html')");

        if (empty($value)) {
            throw new \Exception('Editor value is empty');
        }

        if ($value !== $excepted) {
            throw new \Exception('Editor value not matching : ' . $excepted . ', found :' . $value);
        }
    }
}
