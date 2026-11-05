<?php

namespace VHosting\ToolsSdk\Requests\Proxmox\Kickstart;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\Proxmox\Kickstart;
use VHosting\ToolsSdk\Types\Proxmox\KickstartType;

class GetKickstart extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected readonly int $vmId)
    {
    }

    public function resolveEndpoint(): string
    {
        return sprintf("/api/proxmox/vm/%d/kickstart", $this->vmId);
    }

    public function createDtoFromResponse(Response $response): Kickstart
    {
        $data = fluent($response->json());

        return new Kickstart(
            enabled: $data->boolean('enabled'),
            type: $data->enum('type', KickstartType::class),
            content: $data->string('content'),
        );
    }
}
