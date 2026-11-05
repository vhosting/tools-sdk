<?php

namespace VHosting\ToolsSdk\Requests\Proxmox\Kickstart;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteKickstart extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(protected readonly int $vmId)
    {
    }

    public function resolveEndpoint(): string
    {
        return sprintf("/api/proxmox/vm/%d/kickstart", $this->vmId);
    }
}
