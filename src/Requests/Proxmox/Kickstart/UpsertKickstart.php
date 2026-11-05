<?php

namespace VHosting\ToolsSdk\Requests\Proxmox\Kickstart;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use VHosting\ToolsSdk\Types\Proxmox\Kickstart;
use VHosting\ToolsSdk\Types\Proxmox\KickstartType;

class UpsertKickstart extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected readonly int $vmId,
        protected readonly bool $enabled,
        protected readonly KickstartType $type,
        protected readonly string $content,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return sprintf("/api/proxmox/vm/%d/kickstart", $this->vmId);
    }

    protected function defaultBody(): array
    {
        return [
            'enabled' => $this->enabled,
            'type' => $this->type->value,
            'content' => $this->content,
        ];
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
