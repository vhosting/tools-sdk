<?php

namespace VHosting\ToolsSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\PaginationPlugin\Paginator;
use VHosting\ToolsSdk\Requests\DispatchWorkflow;
use VHosting\ToolsSdk\Requests\GetWorkflow;
use VHosting\ToolsSdk\Requests\GetWorkflows;
use VHosting\ToolsSdk\Requests\RetryWorkflow;
use VHosting\ToolsSdk\Types\Workflow;

class WorkflowResource extends BaseResource
{
    /**
     * @return Paginator<Workflow>
     */
    public function all(): Paginator
    {
        return $this->connector->paginate(new GetWorkflows());
    }
    
    public function get(int $id): Workflow
    {
        return $this->connector->send(new GetWorkflow($id))->dto();
    }
    
    public function retry(int $id): void
    {
        $this->connector->send(new RetryWorkflow($id));
    }
    
    public function dispatch(string $type, array $data = []): Workflow
    {
        return $this->connector->send(new DispatchWorkflow($type, $data))->dto();
    }
}
