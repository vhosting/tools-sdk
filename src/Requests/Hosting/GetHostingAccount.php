<?php

namespace VHosting\ToolsSdk\Requests\Hosting;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\Domain\Domain;
use VHosting\ToolsSdk\Types\Domain\DomainCheck;
use VHosting\ToolsSdk\Types\Hosting\Account;
use VHosting\ToolsSdk\Types\ProxmoxVm;

class GetHostingAccount extends Request
{
    protected Method $method = Method::GET;
    
    public function __construct(public readonly int $id)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf('/api/hosting/%d', $this->id);
    }
    
    public function createDtoFromResponse(Response $response): Account
    {
        $data = fluent($response->json());
        
        return new Account(
            product_status: $data->string('product_status'),
            domain: $data->string('domain'),
            data: $data->array('data'),
        );
    }
}
