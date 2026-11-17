<?php

namespace VHosting\ToolsSdk\Types\Proxmox;

use VHosting\ToolsSdk\Types\BaseType;

class FirewallIpset extends BaseType
{
    public function __construct(
        public string $cidr,
        public string $comment,
    ) {
    }
}
