<?php

namespace VHosting\ToolsSdk\Types\Proxmox;

use VHosting\ToolsSdk\Types\BaseType;

class FirewallOption extends BaseType
{
    public function __construct(
        public string $option,
        public string $value,
    ) {
    }
}
