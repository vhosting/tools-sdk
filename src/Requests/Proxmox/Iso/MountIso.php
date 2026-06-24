<?php

namespace VHosting\ToolsSdk\Requests\Proxmox\Iso;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class MountIso extends Request
{
    protected Method $method = Method::POST;
    
    public function __construct(protected readonly int $vmId, protected readonly int $isoId)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf("/api/proxmox/vm/%d/iso/mount/%d", $this->vmId, $this->isoId);
    }
}