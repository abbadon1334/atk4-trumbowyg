<?php

declare(strict_types=1);

namespace Atk4\TextEditor\Demos\Model;

use Atk4\Data\Model;

class Post extends Model
{
    public $table = 'post';

    protected function init(): void
    {
        parent::init();

        $this->addField('subject');
        $this->addField('body');
    }
}
