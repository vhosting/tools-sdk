<?php

namespace VHosting\ToolsSdk\Requests\Proxmox;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\ProxmoxVm;

class GetVm extends Request
{
    protected Method $method = Method::GET;
    
    public function __construct(public readonly int $id)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf("/api/proxmox/vm/%d", $this->id);
    }
    
    public function createDtoFromResponse(Response $response): ProxmoxVm
    {
        $data = fluent($response->json());
        
        return new ProxmoxVm(
            id: $data->integer('id'),
            type: $data->string('type'),
            node_id: $data->integer('node_id'),
            plan_id: $data->integer('plan_id'),
            hostname: $data->string('hostname'),
            vm_status: $data->string('vm_status'),
            product_status: $data->string('product_status'),
            phpmyadmin_url: $data->get('phpmyadmin_url'),
            created_at: $data->string('created_at'),
            updated_at: $data->string('updated_at'),
        );
    }
}
