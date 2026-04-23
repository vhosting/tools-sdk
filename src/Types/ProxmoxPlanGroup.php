<?php

namespace VHosting\ToolsSdk\Types;

class ProxmoxPlanGroup
{
    public function __construct(
        public int $id,
        public string $name,
        public string $hostname,
        public ?string $created_at,
        public ?string $updated_at,
    )
    {
    }
}