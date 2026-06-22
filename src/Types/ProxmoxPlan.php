<?php

namespace VHosting\ToolsSdk\Types;

class ProxmoxPlan extends BaseType
{
    public function __construct(
        public int $id,
        public int $plan_group_id,
        public string $name,
        public ?string $description,
        public string $type,
        public array $configuration,
        public array $firewall_options,
        public ?string $created_at,
        public ?string $updated_at,
        public ProxmoxPlanGroup $plan_group,
    )
    {
    }
}