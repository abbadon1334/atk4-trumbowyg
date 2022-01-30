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
        //$session->evaluateScript('$.fn.extend({backspace:function(e,t){var n;return n=$.extend({callback:function(){},keypress:function(){},t:100,e:.04},t),this.each(function(){var t;t=this,$(t).queue(function(){var i,a;a=function(e,i){e?(t[/(np|x)/i.test(t.tagName)?"value":"innerHTML"]=t[/(np|x)/i.test(t.tagName)?"value":"innerHTML"].slice(0,-1),n.keypress.call(t),setTimeout(function(){a(e-1,i)},n.t)):(n.callback.call(t),$(t).dequeue())},i=function(e,a){e?(t[/(np|x)/i.test(t.tagName)?"value":"innerHTML"]+=e[0],n.keypress.call(t),setTimeout(function(){i(e.slice(1),a)},n.t)):a()},a(e)})})},typetype:function(e,t){var n;return n=$.extend({callback:function(){},keypress:function(){},t:100,e:.04},t),this.each(function(){var t;t=this,$(t).queue(function(){var i,a,c;a=function(e,i){e?(t[/(np|x)/i.test(t.tagName)?"value":"innerHTML"]=t[/(np|x)/i.test(t.tagName)?"value":"innerHTML"].slice(0,-1),n.keypress.call(t),setTimeout(function(){a(e-1,i)},n.t)):i()},i=function(e,a){e?(t[/(np|x)/i.test(t.tagName)?"value":"innerHTML"]+=e[0],n.keypress.call(t),setTimeout(function(){i(e.slice(1),a)},n.t)):a()},(c=function(u){var s,l;s=function(){return setTimeout(function(){c(u)},Math.random()*n.t*(e[u-1]===e[u]?1.6:"."===e[u-1]?12:"!"===e[u-1]?12:"?"===e[u-1]?12:"\n"===e[u-1]?12:","===e[u-1]?8:";"===e[u-1]?8:":"===e[u-1]?8:" "===e[u-1]?3:2))},l=Math.random()/n.e,e.length>=u?.3>l&&e[u-1]!==e[u]&&e.length>u+4?i(e.slice(u,u+4),function(){a(4,s)}):.7>l&&u>1&&/[A-Z]/.test(e[u-2]&&e.length>u+4)?i(e[u-1].toUpperCase()+e.slice(u,u+4),function(){a(5,s)}):.5>l&&e[u-1]!==e[u]&&e.length>u?i(e[u],function(){a(1,s)}):1>l&&e[u-1]!==e[u]&&e.length>u?i(e[u]+e[u-1],function(){a(2,s)}):.5>l&&/[A-Z]/.test(e[u])?i(e[u].toLowerCase(),function(){a(1,s)}):(t[/(np|x)/i.test(t.tagName)?"value":"innerHTML"]+=e[u-1],n.keypress.call(t),setTimeout(function(){c(u+1)},Math.random()*n.t*(e[u-1]===e[u]?1.6:"."===e[u-1]?12:"!"===e[u-1]?12:"?"===e[u-1]?12:"\n"===e[u-1]?12:","===e[u-1]?8:";"===e[u-1]?8:":"===e[u-1]?8:" "===e[u-1]?3:2))):(n.callback.call(t),$(t).dequeue())})(1)})})}});');

        $session->executeScript("$('#" . $id . "-editor').innerHTML = '" . $text . "';");
        $session->executeScript("$('#" . $id . "-editor').trigger('keyup')");
    }

    /**
     * @Then Modal is open with raw text :arg1
     * @Then Modal is open with raw text :arg1 in tag :arg2
     *
     * Check if text is present in modal or dynamic modal.
     */
    public function modalIsOpenWithRawText(string $text, string $tag = 'div'): void
    {
        $modal = $this->getElementInPage('.modal.visible.active.front');
        $this->getElementInElement($modal, '//' . $tag . '[text()["' . $text . '"]]', 'xpath');
    }

    /**
     * @Then /^Editor "([^"]*)" value should be equal to "([^"]*)"$/
     */
    public function editorValueShouldBeEqualTo(string $name, string $excepted): void
    {
        $value = $this->getElementInPage("textarea[name='" . $name . "']")->getValue();

        if (empty($value)) {
            throw new \Exception('Editor value is empty');
        }

        if ($value !== $excepted) {
            throw new \Exception('Editor value not matching : ' . $excepted . ', found :' . $value);
        }
    }
}
