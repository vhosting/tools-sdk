<?php

namespace VHosting\ToolsSdk\Requests\Workflow;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use VHosting\ToolsSdk\Types\Workflow;

class DispatchWorkflow extends Request implements HasBody
{
    use HasJsonBody;
    
    protected Method $method = Method::POST;
    
    public function __construct(protected string $type, protected array $data = [])
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf("/api/workflows/dispatch/%s", $this->type);
    }
    
    protected function defaultBody(): array
    {
        return $this->data;
    }
    
    public function createDtoFromResponse(Response $response): Workflow
    {
        $data = fluent($response->json());
        
        return new Workflow(
            id: $data->integer('id'),
            type: $data->string('type'),
            description: $data->string('description'),
            status: $data->string('status'),
            payload: $data->array('payload'),
            created_at: $data->string('created_at'),
            updated_at: $data->string('updated_at'),
            tasks_count: $data->integer('tasks_count'),
            completed_tasks_count: $data->integer('completed_tasks_count'),
            tasks: $data->collect('tasks'),
        );
    }
}
