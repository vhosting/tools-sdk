<?php

namespace VHosting\ToolsSdk\Requests\Workflow;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use VHosting\ToolsSdk\Types\Workflow;

class GetWorkflows extends Request implements Paginatable
{
    protected Method $method = Method::GET;
    
    public function resolveEndpoint(): string
    {
        return '/api/workflows';
    }
    
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(function (array $item){
            $data = fluent($item);
            
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
        }, $response->json('data'));
    }
}
