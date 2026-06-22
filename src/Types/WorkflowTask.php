<?php

namespace VHosting\ToolsSdk\Types;

class WorkflowTask extends BaseType
{
    public function __construct(
        public int $id,
        public int $workflow_id,
        public string $description,
        public int $order,
        public string $status,
        public ?string $error,
        public ?string $started_at,
        public ?string $stopped_at,
        public ?string $created_at,
        public ?string $updated_at,
    ){}
}