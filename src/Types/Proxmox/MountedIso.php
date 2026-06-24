<?php

namespace VHosting\ToolsSdk\Types\Proxmox;

use VHosting\ToolsSdk\Types\BaseType;
use VHosting\ToolsSdk\Types\ProxmoxIpType;

class MountedIso extends BaseType
{
    public function __construct(
        public bool $mounted,
        public string $iso,
    ) {
    }
}