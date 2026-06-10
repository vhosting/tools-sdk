<?php

namespace VHosting\ToolsSdk\Types\Proxmox;

class VncProxy
{
    public function __construct(
        public int $port,
        public string $password,
    ) {
    }
}