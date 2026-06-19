<?php

namespace VHosting\ToolsSdk\Requests\Proxmox;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\Proxmox\Rdns;
use VHosting\ToolsSdk\Types\ProxmoxIp;
use VHosting\ToolsSdk\Types\ProxmoxIpType;
use VHosting\ToolsSdk\Types\ProxmoxPlan;
use VHosting\ToolsSdk\Types\ProxmoxVm;

class GetVmRdns extends Request
{
    protected Method $method = Method::GET;
    
    public function __construct(protected readonly int $id)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf("/api/proxmox/vm/%d/rdns", $this->id);
    }
    
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(function (array $item){
            $data = fluent($item);
        
            return new Rdns(
                ip: $data->string('ip'),
                reverse: $data->get('reverse'),
            );
            
        }, $response->json());
    }
}
