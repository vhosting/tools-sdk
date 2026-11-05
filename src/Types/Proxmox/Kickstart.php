<?php

namespace VHosting\ToolsSdk\Types\Proxmox;

use VHosting\ToolsSdk\Types\BaseType;

class Kickstart extends BaseType
{
    public function __construct(
        public bool $enabled,
        public KickstartType $type,
        public string $content,
    ) {
    }
}
