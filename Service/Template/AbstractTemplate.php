<?php

namespace Rewsam\DevelopmentAssist\Service\Template;

abstract class AbstractTemplate implements Template
{
    /**
     * @var string
     */
    protected $destination;
    /**
     * @var string
     */
    protected $content;

    public function __construct(string $destination, string $content)
    {
        $this->destination = $destination;
        $this->content = $content;
    }
}
