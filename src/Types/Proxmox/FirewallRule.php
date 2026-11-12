<?php

namespace VHosting\ToolsSdk\Types\Proxmox;

use VHosting\ToolsSdk\Types\BaseType;

class FirewallRule extends BaseType
{
    public function __construct(
        public ?string $source,
        public bool $enable,
        public string $action,
        public string $type,
    ) {
    }
}
