<?php

namespace VHosting\ToolsSdk\Requests\Proxmox;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\ProxmoxBackup;
use VHosting\ToolsSdk\Types\ProxmoxIp;
use VHosting\ToolsSdk\Types\ProxmoxIpType;
use VHosting\ToolsSdk\Types\ProxmoxPlan;
use VHosting\ToolsSdk\Types\ProxmoxSnapshot;
use VHosting\ToolsSdk\Types\ProxmoxVm;

class GetVmSnapshots extends Request
{
    protected Method $method = Method::GET;
    
    public function __construct(protected readonly int $id)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf("/api/proxmox/vm/%d/snapshots", $this->id);
    }
    
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(function (array $item){
            $data = fluent($item);
        
            return new ProxmoxSnapshot(
                name: $data->get('name'),
                description: $data->get('description'),
                parent: $data->get('parent'),
                created_at: $data->date('created_at'),
                is_current: $data->boolean('current'),
            );
            
        }, $response->json());
    }
}
