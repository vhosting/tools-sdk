<?php

namespace VHosting\ToolsSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\PaginationPlugin\Paginator;
use VHosting\ToolsSdk\Requests\Workflow\DispatchWorkflow;
use VHosting\ToolsSdk\Requests\Workflow\GetWorkflow;
use VHosting\ToolsSdk\Requests\Workflow\GetWorkflows;
use VHosting\ToolsSdk\Requests\Workflow\RetryWorkflow;
use VHosting\ToolsSdk\Types\Workflow;

class WorkflowResource extends BaseResource
{
    /**
     * @return Paginator<Workflow>
     */
    public function all(?int $vmId = null): Paginator
    {
        $request = new GetWorkflows();
        $request->query()->add('vm_id', $vmId);
        
        return $this->connector->paginate($request);
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
