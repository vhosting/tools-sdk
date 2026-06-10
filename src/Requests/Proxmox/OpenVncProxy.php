<?php

namespace VHosting\ToolsSdk\Requests\Proxmox;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\Proxmox\VncProxy;

class OpenVncProxy extends Request
{
    protected Method $method = Method::POST;
    
    public function __construct(protected readonly int $id)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf("/api/proxmox/vm/%d/vncproxy", $this->id);
    }
    
    public function createDtoFromResponse(Response $response): VncProxy
    {
        $data = fluent($response->json());
        
        return new VncProxy(
            port: $data->integer('port'),
            password: $data->string('password'),
        );
    }
}