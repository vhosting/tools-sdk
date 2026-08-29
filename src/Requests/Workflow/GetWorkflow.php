<?php

namespace VHosting\ToolsSdk\Requests\Workflow;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\Workflow;

class GetWorkflow extends Request
{
    protected Method $method = Method::GET;
    
    public function __construct(protected readonly int $id)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf("/api/workflows/%d", $this->id);
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
