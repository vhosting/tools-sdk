<?php

namespace VHosting\ToolsSdk\Types;

class ProxmoxIp extends BaseType
{
    public function __construct(
        public int $id,
        public int $cluster_id,
        public int $plan_group_id,
        public string $ip,
        public string $cidr,
        public string $gateway,
        public string $bridge,
        public ProxmoxIpType $type,
        public bool $enabled,
        public ?string $note,
        public bool $reserved,
        public ?string $created_at,
        public ?string $updated_at,
    )
    {
    }
}