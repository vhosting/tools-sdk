<?php

namespace VHosting\ToolsSdk\Requests\Task;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use VHosting\ToolsSdk\Types\Enums\TaskPriority;
use VHosting\ToolsSdk\Types\Enums\TaskStatus;
use VHosting\ToolsSdk\Types\Workflow;

class CreateTask extends Request implements HasBody
{
    use HasJsonBody;
    
    protected Method $method = Method::POST;
    
    public function __construct(
        protected string $title,
        protected int $category_id,
        protected ?string $description = null,
        protected TaskStatus $status = TaskStatus::Pending,
        protected TaskPriority $priority = TaskPriority::Medium,
        protected ?string $expires_at = null,
        protected array $assignees = [],
    ) {
    }
    
    public function resolveEndpoint(): string
    {
        return '/api/todo/task';
    }
    
    protected function defaultBody(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->value,
            'category_id' => $this->category_id,
            'priority' => $this->priority->value,
            'expires_at' => $this->expires_at,
            'assignees' => $this->assignees,
        ];
    }
    
    // TODO: createDtoFromResponse
}
