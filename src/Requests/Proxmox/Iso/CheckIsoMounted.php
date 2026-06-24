<?php

namespace VHosting\ToolsSdk\Requests\Proxmox\Iso;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\Proxmox\MountedIso;

class CheckIsoMounted extends Request
{
    protected Method $method = Method::GET;
    
    public function __construct(protected readonly int $id)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf("/api/proxmox/vm/%d/iso/mounted", $this->id);
    }
    
    public function createDtoFromResponse(Response $response): MountedIso
    {
        $data = fluent($response->json());

        return new MountedIso(
            mounted: $data->boolean('mounted'),
            iso: $data->get('iso'),
        );
    }
}
