<?php

namespace VHosting\ToolsSdk\Requests\Proxmox;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\ProxmoxBackup;
use VHosting\ToolsSdk\Types\ProxmoxIp;
use VHosting\ToolsSdk\Types\ProxmoxIpType;
use VHosting\ToolsSdk\Types\ProxmoxPlan;
use VHosting\ToolsSdk\Types\ProxmoxVm;

class GetVmBackups extends Request
{
    protected Method $method = Method::GET;
    
    public function __construct(protected readonly int $id)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf("/api/proxmox/vm/%d/backups", $this->id);
    }
    
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(function (array $item){
            $data = fluent($item);
        
            return new ProxmoxBackup(
                size: $data->string('size'),
                created: $data->string('created'),
            );
            
        }, $response->json());
    }
}
