<?php

namespace VHosting\ToolsSdk;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\Paginator;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use VHosting\ToolsSdk\Resources\ProxmoxVmResource;
use VHosting\ToolsSdk\Resources\WorkflowResource;

class ToolsConnector extends Connector implements HasPagination
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;
    
    public function __construct(
        protected readonly string $apiKey,
        protected readonly string $baseUrl = 'https://tools.vhosting-it.com/',
    ) {
    }
    
    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }
    
    protected function defaultAuth(): ?Authenticator
    {
        return new TokenAuthenticator($this->apiKey);
    }
    
    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
    
    public function paginate(Request $request): Paginator
    {
        return new LaravelResourcePaginator($this, $request);
    }
    
    public function workflow(): WorkflowResource
    {
        return new WorkflowResource($this);
    }
    
    public function proxmoxVm(): ProxmoxVmResource
    {
        return new ProxmoxVmResource($this);
    }
}