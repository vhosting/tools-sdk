<?php

namespace VHosting\ToolsSdk\Requests\Servers;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\Enums\ServerPanel;
use VHosting\ToolsSdk\Types\Server;

class GetServers extends Request
{
    protected Method $method = Method::GET;
    
    public function resolveEndpoint(): string
    {
        return '/api/server/info';
    }
    
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(function(array $item){
            $data = fluent($item);
            
            return new Server(
                id: $data->integer('id'),
                name: $data->string('name'),
                ip4: $data->string('ip4'),
                ip6: $data->get('ip6'),
                panel: $data->enum('panel', ServerPanel::class),
                auth_key: $data->string('auth_key'),
                created_at: $data->date('created_at'),
                updated_at: $data->date('updated_at'),
            );
        }, $response->json());
    }
    
}