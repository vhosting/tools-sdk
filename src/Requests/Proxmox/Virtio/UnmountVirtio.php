<?php

namespace VHosting\ToolsSdk\Requests\Proxmox\Virtio;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class UnmountVirtio extends Request
{
    protected Method $method = Method::POST;
    
    public function __construct(protected readonly int $id)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf("/api/proxmox/vm/%d/virtio/unmount", $this->id);
    }
}