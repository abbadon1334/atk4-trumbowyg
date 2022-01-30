<?php

declare(strict_types=1);

namespace Atk4\TextEditor\Behat;

class Context extends \Atk4\Ui\Behat\Context
{
    /**
     * @When I type in editor :id with text :text
     */
    public function iTypeInEditor(string $id, string $text): void
    {
        $session = $this->getSession();

        $session->executeScript("$('#" . $id . "-editor').html('" . $text . "')");
    }

    /**
     * @Then Modal is open with raw text :arg1
     * @Then Modal is open with raw text :arg1 in tag :arg2
     *
     * Check if text is present in modal or dynamic modal.
     */
    public function modalIsOpenWithRawText(string $text, string $tag = 'div'): void
    {
        $html = $this->getElementInPage('.modal.visible.active.front')->getHtml();

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
        $value = $this->getElementInPage('textarea[name="' . $name . '"]')->getValue();

        if (empty($value)) {
            throw new \Exception('Editor value is empty');
        }

        if ($value !== $excepted) {
            throw new \Exception('Editor value not matching : ' . $excepted . ', found :' . $value);
        }
    }
}
