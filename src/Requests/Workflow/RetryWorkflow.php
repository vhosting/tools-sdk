<?php

namespace VHosting\ToolsSdk\Requests\Workflow;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class RetryWorkflow extends Request
{
    protected Method $method = Method::PUT;
    
    public function __construct(protected readonly int $id)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf("/api/workflows/%d/retry", $this->id);
    }
}
