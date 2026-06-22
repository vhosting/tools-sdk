<?php

namespace VHosting\ToolsSdk\Types\Proxmox;

use VHosting\ToolsSdk\Types\BaseType;

class VncProxy extends BaseType
{
    public function __construct(
        public string $host,
        public int $port,
        public string $password,
    ) {
    }
}