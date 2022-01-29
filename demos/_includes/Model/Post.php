<?php

declare(strict_types=1);

namespace Atk4\Ui\Demos\Model;

class Post extends \Atk4\Data\Model
{
    public $table = 'post';

    protected function init(): void
    {
        parent::init();

        $this->addField('subject');
        $this->addField('body');
    }
}
