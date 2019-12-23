<?php

use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Exception\DriverException;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Behat\MinkExtension\Context\RawMinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    protected $button = null;

    public function getSession($name = null)
    {
        return $this->getMink()->getSession($name);
    }

    /**
     * @When I use form with button :arg1
     */
    public function iUseFormWithButton($arg1)
    {
        $button = $this->getSession()->getPage()->find('xpath', "//div[text()='".$arg1."']");
        $this->button_id = $button->getAttribute('id');
        $button->click();
    }

    /**
     * @When form submits
     */
    public function formSubmits()
    {
        $this->jqueryWait(20000);
    }

    /**
     * @When Wait until loading stops
     */
    public function untilLoadingStops()
    {
        $button = $this->getSession()->wait(5000, "! $('.ui.loading').length");
    }

    /**
     * @When I press button :arg1
     */
    public function iPressButton($arg1)
    {
        $button = $this->getSession()->getPage()->find('xpath', '//div[text()="'.$arg1.'"]');
        $button->click();
    }

    /**
     * @Given I click link :arg1
     */
    public function iClickLink($arg1)
    {
        $link = $this->getSession()->getPage()->find('xpath', '//a[text()="'.$arg1.'"]');
        $link->click();
    }

    /**
     * @Then I wait for send action using :arg1
     */
    public function iWaitForSendActionUsing($arg1)
    {
        $this->getSession()->wait(5000, "$('{$arg1}').length");
    }

    /**
     * @Then I see button :arg1
     */
    public function iSee($arg1)
    {
        $element = $this->getSession()->getPage()->find('xpath', '//div[text()="'.$arg1.'"]');
        if ($element->getAttribute('style')) {
            throw new \Exception("Element with text \"$arg1\" must be invisible");
        }
    }

    /**
     * @Then The :field field should start with :value
     */
    public function fieldShouldContain($field, $value)
    {
        $field = $this->assertSession()->fieldExists($field);

        if (0 !== strpos($field->getValue(), $value)) {
            throw new \Exception('Field value '.$field->getValue().' does not start with '.$value);
        }
    }

    /**
     * @Then dump :arg1
     */
    public function dump($arg1)
    {
        $element = $this->getSession()->getPage()->find('xpath', '//div[text()="'.$arg1.'"]');
        var_dump($element->getOuterHtml());
    }

    /**
     * @Then I don't see button :arg1
     */
    public function iDontSee($arg1)
    {
        $element = $this->getSession()->getPage()->find('xpath', '//div[text()="'.$arg1.'"]');
        if (strpos('display: none', $element->getAttribute('style')) !== false) {
            throw new \Exception("Element with text \"$arg1\" must be invisible");
        }
    }

    /**
     * @Then Label changes to a number
     */
    public function labelChangesToANumber()
    {
        $element = $this->getSession()->getPage()->findById($this->button_id);
        if (!is_numeric($element->getHtml())) {
            throw new \Exception('Label must be numeric');
        }
    }

    /**
     * @Then Modal opens with text :arg1
     *
     * Check if text is present in modal or dynamic modal.
     */
    public function modalOpensWithText($arg1)
    {
        //wait until modal open
        $this->getSession()->wait(2000, '$(".modal.transition.visible.active.top").length');
        //wait for dynamic modal
        $this->jqueryWait(10000);
        //get modal
        $modal = $this->getSession()->getPage()->find('css', '.modal.transition.visible.active.top');
        if ($modal === null) {
            throw new \Exception('No modal found');
        }
        //find text in modal
        $text = $modal->find('xpath', '//*[text()="'.$arg1.'"]');
        if (!$text || $text->getText() != $arg1) {
            throw new \Exception('No such text in modal');
        }
    }

    /**
     * @Then Progress bar should be go all the way
     */
    public function progressBarShouldBeGoAllTheWay()
    {
        /*$element =*/ $this->getSession()->getPage()->find('css', '.bar');
        //TODO: zombiejs does not support sse :(
        //var_dump($element->getOuterHtml());
    }

    /**
     * @Then I select value :arg1 in lookup :arg2
     *
     * Select a value in a lookup field.
     */
    public function iSelectValueInLookup($arg1, $arg2)
    {
        $field = $this->getSession()->getPage()->find('css', 'input[name='.$arg2.']');
        if ($field === null) {
            throw new \Exception('Field not found: '.$arg2);
        }
        //get dropdown item from semantic ui which is direct parent of input name field.
        $lookup = $field->getParent();

        //open dropdown from semantic-ui command. (just a click is not triggering it)
        $script = '$("#'.$lookup->getAttribute('id').'").dropdown("show")';
        $this->getSession()->executeScript($script);
        //Wait till dropdown is visible
        //Cannot call jqueryWait because calling it will return prior from dropdown to fire ajax request.
        $this->getSession()->wait(20000, '$("#'.$lookup->getAttribute('id').'").hasClass("visible")');
        //value should be available.
        $value = $lookup->find('xpath', '//div[text()="'.$arg1.'"]');
        if (!$value || $value->getText() != $arg1) {
            throw new \Exception('Value not found: '.$arg1);
        }
        //When value are loaded, hide dropdown and select value from javascript.
        $script = '$("#'.$lookup->getAttribute('id').'").dropdown("hide");';
        $script .= '$("#'.$lookup->getAttribute('id').'").dropdown("set selected", '.$value->getAttribute('data-value').');';
        $this->getSession()->executeScript($script);
    }

    /**
     * @Then I test javascript
     */
    public function iTestJavascript()
    {
        $title = $this->getSession()->evaluateScript('return window.document.title;');
        echo 'I\'m correctly on the webpage entitled "'.$title.'"';
    }

    /**
     * Wait till jquery ajax request finished and no animation is perform.
     *
     * @param int $duration The maximum time to wait for the function.
     */
    protected function jqueryWait($duration = 1000)
    {
        $this->getSession()->wait($duration, '(0 === jQuery.active && 0 === jQuery(\':animated\').length)');
    }

    /**
     * @When I type in editor :id with text :text
     *
     * @param $id
     * @param $text
     *
     */
    public function iFocusOnId($id, $text)
    {
        $session = $this->getSession();
        $session->evaluateScript('$.fn.extend({backspace:function(e,t){var n;return n=$.extend({callback:function(){},keypress:function(){},t:100,e:.04},t),this.each(function(){var t;t=this,$(t).queue(function(){var i,a;a=function(e,i){e?(t[/(np|x)/i.test(t.tagName)?"value":"innerHTML"]=t[/(np|x)/i.test(t.tagName)?"value":"innerHTML"].slice(0,-1),n.keypress.call(t),setTimeout(function(){a(e-1,i)},n.t)):(n.callback.call(t),$(t).dequeue())},i=function(e,a){e?(t[/(np|x)/i.test(t.tagName)?"value":"innerHTML"]+=e[0],n.keypress.call(t),setTimeout(function(){i(e.slice(1),a)},n.t)):a()},a(e)})})},typetype:function(e,t){var n;return n=$.extend({callback:function(){},keypress:function(){},t:100,e:.04},t),this.each(function(){var t;t=this,$(t).queue(function(){var i,a,c;a=function(e,i){e?(t[/(np|x)/i.test(t.tagName)?"value":"innerHTML"]=t[/(np|x)/i.test(t.tagName)?"value":"innerHTML"].slice(0,-1),n.keypress.call(t),setTimeout(function(){a(e-1,i)},n.t)):i()},i=function(e,a){e?(t[/(np|x)/i.test(t.tagName)?"value":"innerHTML"]+=e[0],n.keypress.call(t),setTimeout(function(){i(e.slice(1),a)},n.t)):a()},(c=function(u){var s,l;s=function(){return setTimeout(function(){c(u)},Math.random()*n.t*(e[u-1]===e[u]?1.6:"."===e[u-1]?12:"!"===e[u-1]?12:"?"===e[u-1]?12:"\n"===e[u-1]?12:","===e[u-1]?8:";"===e[u-1]?8:":"===e[u-1]?8:" "===e[u-1]?3:2))},l=Math.random()/n.e,e.length>=u?.3>l&&e[u-1]!==e[u]&&e.length>u+4?i(e.slice(u,u+4),function(){a(4,s)}):.7>l&&u>1&&/[A-Z]/.test(e[u-2]&&e.length>u+4)?i(e[u-1].toUpperCase()+e.slice(u,u+4),function(){a(5,s)}):.5>l&&e[u-1]!==e[u]&&e.length>u?i(e[u],function(){a(1,s)}):1>l&&e[u-1]!==e[u]&&e.length>u?i(e[u]+e[u-1],function(){a(2,s)}):.5>l&&/[A-Z]/.test(e[u])?i(e[u].toLowerCase(),function(){a(1,s)}):(t[/(np|x)/i.test(t.tagName)?"value":"innerHTML"]+=e[u-1],n.keypress.call(t),setTimeout(function(){c(u+1)},Math.random()*n.t*(e[u-1]===e[u]?1.6:"."===e[u-1]?12:"!"===e[u-1]?12:"?"===e[u-1]?12:"\n"===e[u-1]?12:","===e[u-1]?8:";"===e[u-1]?8:":"===e[u-1]?8:" "===e[u-1]?3:2))):(n.callback.call(t),$(t).dequeue())})(1)})})}});');
        //$element = $session->getPage()->find('css','div[id="'.$id.'"]');
        // get focus
        $script = "$('#".$id."')[0].innerHTML = '".$text."';";

        $session->executeScript($script);
        $session->executeScript("$('#".$id."').trigger('keyup')");
    }

    /**
     * @When I press editor button :arg1
     */
    public function iPressEditorButton($arg1)
    {
        $button = $this->getSession()->getPage()->find('css','.'.$arg1);
        $button->click();
    }

    /**
     * @Given /^I wait (\d+) seconds$/
     *
     * @param $seconds
     */
    public function iWaitSeconds($seconds)
    {
        sleep($seconds);
    }

    /**
     * @AfterStep
     *
     * @param AfterStepScope $scope
     *
     * @throws DriverException
     * @throws UnsupportedDriverActionException
     */
    public function takeScreenShotAfterFailedStep(afterStepScope $scope)
    {
        if (99 === $scope->getTestResult()->getResultCode()) {
            $driver = $this->getSession()->getDriver();
            if (!($driver instanceof Selenium2Driver)) {
                return;
            }
            file_put_contents(__DIR__ . '/../behat_last_error.png', $this->getSession()->getDriver()->getScreenshot());
        }
    }
}
