<?php

namespace VHosting\ToolsSdk\Requests\Proxmox;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\ProxmoxIp;
use VHosting\ToolsSdk\Types\ProxmoxIpType;
use VHosting\ToolsSdk\Types\ProxmoxPlan;
use VHosting\ToolsSdk\Types\ProxmoxVm;

class GetVmIps extends Request
{
    protected Method $method = Method::GET;
    
    public function __construct(protected readonly int $id)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf("/api/proxmox/vm/%d/ips", $this->id);
    }
    
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(function (array $item){
            $data = fluent($item);
        
            return new ProxmoxIp(
                id: $data->integer('id'),
                cluster_id: $data->integer('cluster_id'),
                plan_group_id: $data->integer('plan_group_id'),
                ip: $data->string('ip'),
                cidr: $data->string('cidr'),
                gateway: $data->string('gateway'),
                bridge: $data->string('bridge'),
                type: $data->enum('type', ProxmoxIpType::class),
                enabled: $data->boolean('enabled'),
                note: $data->get('note'),
                reserved: $data->boolean('reserved'),
                created_at: $data->string('created_at'),
                updated_at: $data->string('updated_at'),
            );
            
        }, $response->json());
    }
}
