<?php

namespace Notes\Services\Views;

use Notes\Core\Views\AbstractView;

class Note extends AbstractView
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $content;

    /**
     * @var string
     */
    public $created;

    /**
     * @var string
     */
    public $last_updated;
}
