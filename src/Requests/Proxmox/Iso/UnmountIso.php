<?php

namespace VHosting\ToolsSdk\Requests\Proxmox\Iso;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class UnmountIso extends Request
{
    protected Method $method = Method::POST;
    
    public function __construct(protected readonly int $id)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf("/api/proxmox/vm/%d/iso/unmount", $this->id);
    }
}