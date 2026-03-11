<?php

namespace VHosting\ToolsSdk\Types;

use Illuminate\Support\Collection;

class Workflow
{
    public function __construct(
        public int $id,
        public string $type,
        public string $description,
        public string $status,
        public array $payload,
        public ?string $created_at,
        public ?string $updated_at,
        public int $tasks_count,
        public int $completed_tasks_count,
        public Collection $tasks,
    ){
        $this->tasks = $tasks->map(fn(array $item) => new WorkflowTask(
            id: $item['id'],
            workflow_id: $item['workflow_id'],
            description: $item['description'],
            order: $item['order'],
            status: $item['status'],
            error: $item['error'],
            started_at: $item['started_at'],
            stopped_at: $item['stopped_at'],
            created_at: $item['created_at'],
            updated_at: $item['updated_at'],
        ));
    }
}