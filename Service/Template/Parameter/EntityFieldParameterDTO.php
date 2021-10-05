<?php

namespace Rewsam\DevelopmentAssist\Service\Template\Parameter;

class EntityFieldParameterDTO
{
    /** @var string */
    public $name = 'id';

    /** @var string */
    public $type = 'mixed';

    /** @var bool */
    public $isPrimary = false;

    /** @var bool */
    public $isReadOnly = false;

    /** @var bool */
    public $nullable = true;

    /** @var string */
    public $protoName = 'id';

    /** @var string */
    public $protoIndex = 1;

    /** @var string */
    public $protoType = 'string';

    /** @var string */
    public $protoNullable = 'optional';

    /** @var string */
    public $protoSetter = 'setId';

    /** @var string */
    public $protoGetter = 'getId';
}