<?php

namespace VHosting\ToolsSdk\Types\Proxmox;

use VHosting\ToolsSdk\Types\BaseType;

class Firewall extends BaseType
{
    /**
     * @param FirewallRule[] $rules
     * @param string[] $ipset
     * @param FirewallOption[] $options
     */
    public function __construct(
        public array $rules,
        public array $ipset,
        public array $options,
    ) {
    }
}
