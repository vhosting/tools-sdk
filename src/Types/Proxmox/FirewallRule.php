<?php

namespace VHosting\ToolsSdk\Types\Proxmox;

use VHosting\ToolsSdk\Types\BaseType;

class FirewallRule extends BaseType
{
    public function __construct(
        public int $pos,
        public bool $enabled,
        public string $type,
        public string $action,
        public string $proto,
        public ?string $source,
        public string $sport,
        public string $dest,
        public string $dport,
        public string $comment,
    ) {
    }
}
