<?php

namespace VHosting\ToolsSdk\Resources;

use Saloon\Http\Connector;
use VHosting\ToolsSdk\Requests\Proxmox\Iso\CheckIsoMounted;
use VHosting\ToolsSdk\Requests\Proxmox\Iso\GetIsoList;
use VHosting\ToolsSdk\Requests\Proxmox\Iso\MountIso;
use VHosting\ToolsSdk\Requests\Proxmox\Iso\UnmountIso;
use VHosting\ToolsSdk\Types\Proxmox\Iso;

class ProxmoxVmIsoResource
{
    public function __construct(protected readonly Connector $connector, protected readonly int $vmId)
    {
    }
    
    /**
     * @return Iso[]
     */
    public function list(): array
    {
        return $this->connector->send(new GetIsoList($this->vmId))->dto();
    }
    
    public function isMounted(): bool
    {
        return $this->connector->send(new CheckIsoMounted($this->vmId))->dto();
    }
    
    public function mount(int $isoId): void
    {
        $this->connector->send(new MountIso($this->vmId, $isoId));
    }
    
    public function unmount(): void
    {
        $this->connector->send(new UnmountIso($this->vmId));
    }
}
