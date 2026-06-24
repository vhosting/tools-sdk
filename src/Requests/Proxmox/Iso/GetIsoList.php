<?php

namespace VHosting\ToolsSdk\Requests\Proxmox\Iso;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\Proxmox\Iso;

class GetIsoList extends Request
{
    protected Method $method = Method::GET;
    
    public function __construct(protected readonly int $id)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf("/api/proxmox/vm/%d/iso/list", $this->id);
    }
    
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(function (array $item){
            $data = fluent($item);
        
            return new Iso(
                id: $data->integer('id'),
                name: $data->string('name'),
                description: $data->string('description'),
                created_at: $data->string('created_at'),
                updated_at: $data->string('updated_at'),
            );
            
        }, $response->json());
    }
}
