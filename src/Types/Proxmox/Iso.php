<?php

namespace VHosting\ToolsSdk\Types\Proxmox;

use VHosting\ToolsSdk\Types\BaseType;
use VHosting\ToolsSdk\Types\ProxmoxIpType;

class Iso extends BaseType
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public ?string $created_at,
        public ?string $updated_at,
    ) {
    }
}