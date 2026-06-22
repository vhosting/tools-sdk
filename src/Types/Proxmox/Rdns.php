<?php

namespace VHosting\ToolsSdk\Types\Proxmox;

use VHosting\ToolsSdk\Types\BaseType;

class Rdns extends BaseType
{
    public function __construct(
        public string $ip,
        public ?string $hostname,
    ) {
    }
}