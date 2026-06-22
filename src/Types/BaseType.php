<?php

namespace VHosting\ToolsSdk\Types;

abstract class BaseType
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}