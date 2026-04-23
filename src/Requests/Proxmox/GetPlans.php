<?php

namespace VHosting\ToolsSdk\Requests\Proxmox;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\ProxmoxPlan;
use VHosting\ToolsSdk\Types\ProxmoxPlanGroup;

class GetPlans extends Request
{
    protected Method $method = Method::GET;
    
    public function resolveEndpoint(): string
    {
        return sprintf('/api/proxmox/plans');
    }
    
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(function (array $item){
            $data = fluent($item);
            
            return new ProxmoxPlan(
                id: $data->integer('id'),
                plan_group_id: $data->integer('plan_group_id'),
                name: $data->string('name'),
                type: $data->string('type'),
                configuration: $data->array('configuration'),
                firewall_options: $data->array('firewall_options'),
                created_at: $data->string('created_at'),
                updated_at: $data->string('updated_at'),
                plan_group: new ProxmoxPlanGroup(
                    id: $data->integer('plan_group.id'),
                    name: $data->string('plan_group.name'),
                    hostname: $data->string('plan_group.hostname'),
                    created_at: $data->string('plan_group.created_at'),
                    updated_at: $data->string('plan_group.updated_at'),
                ),
            );
        }, $response->json());
    }
}
