<?php

namespace VHosting\ToolsSdk\Types\Proxmox;

class VncProxy
{
    public function __construct(
        public string $host,
        public int $port,
        public string $password,
    ) {
    }
}