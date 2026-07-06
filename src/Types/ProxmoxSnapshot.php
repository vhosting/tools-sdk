<?php

namespace VHosting\ToolsSdk\Types;

use Carbon\Carbon;

class ProxmoxSnapshot extends BaseType
{
    public function __construct(
        public string $name,
        public ?string $description,
        public ?string $parent,
        public Carbon $created_at,
        public bool $is_current,
    ) {
    }
}