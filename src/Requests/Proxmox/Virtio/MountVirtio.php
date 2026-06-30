<?php

namespace VHosting\ToolsSdk\Requests\Proxmox\Virtio;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class MountVirtio extends Request
{
    protected Method $method = Method::POST;
    
    public function __construct(protected readonly int $vmId, protected readonly int $isoId)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf("/api/proxmox/vm/%d/virtio/mount/%d", $this->vmId, $this->isoId);
    }
}