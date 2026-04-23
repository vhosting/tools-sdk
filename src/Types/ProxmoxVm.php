<?php

namespace VHosting\ToolsSdk\Types;

class ProxmoxVm
{
    public function __construct(
        public int $id,
        public string $type,
        public int $node_id,
        public int $plan_id,
        public string $hostname,
        public string $vm_status,
        public string $product_status,
        public ?string $created_at,
        public ?string $updated_at,
    )
    {
    }
}