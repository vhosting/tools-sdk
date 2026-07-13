<?php

namespace VHosting\ToolsSdk\Types;

class ProxmoxVm extends BaseType
{
    public function __construct(
        public int $id,
        public string $type,
        public int $node_id,
        public int $plan_id,
        public string $hostname,
        public string $vm_status,
        public string $product_status,
        public ?string $phpmyadmin_url,
        public ?string $dns1,
        public ?string $dns2,
        public ?string $ntp1,
        public ?string $ntp2,
        public ?string $created_at,
        public ?string $updated_at,
    )
    {
    }
}