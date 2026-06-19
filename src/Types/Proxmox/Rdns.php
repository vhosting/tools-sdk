<?php

namespace VHosting\ToolsSdk\Types\Proxmox;

class Rdns
{
    public function __construct(
        public string $ip,
        public ?string $reverse,
    ) {
    }
}