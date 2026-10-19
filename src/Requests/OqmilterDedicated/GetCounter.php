<?php

namespace VHosting\ToolsSdk\Requests\OqmilterDedicated;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\Domain\Domain;
use VHosting\ToolsSdk\Types\Domain\DomainCheck;
use VHosting\ToolsSdk\Types\ProxmoxVm;

class GetCounter extends Request
{
    protected Method $method = Method::GET;
    
    public function __construct(public readonly string $domain)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf('/api/oqmilter-ded/%s/counter', $this->domain);
    }
    
    public function createDtoFromResponse(Response $response): int
    {
        return (int)$response->body();
    }
}
