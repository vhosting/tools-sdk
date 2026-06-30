<?php

namespace VHosting\ToolsSdk\Resources;

use Saloon\Http\Connector;
use VHosting\ToolsSdk\Requests\Proxmox\Virtio\CheckVirtioMounted;
use VHosting\ToolsSdk\Requests\Proxmox\Virtio\GetVirtioList;
use VHosting\ToolsSdk\Requests\Proxmox\Virtio\MountVirtio;
use VHosting\ToolsSdk\Requests\Proxmox\Virtio\UnmountVirtio;
use VHosting\ToolsSdk\Types\Proxmox\Iso;
use VHosting\ToolsSdk\Types\Proxmox\MountedIso;

class ProxmoxVmVirtioResource
{
    public function __construct(protected readonly Connector $connector, protected readonly int $vmId)
    {
    }
    
    /**
     * @return Iso[]
     */
    public function list(): array
    {
        return $this->connector->send(new GetVirtioList($this->vmId))->dto();
    }
    
    public function check(): MountedIso
    {
        return $this->connector->send(new CheckVirtioMounted($this->vmId))->dto();
    }
    
    public function mount(int $isoId): void
    {
        $this->connector->send(new MountVirtio($this->vmId, $isoId));
    }
    
    public function unmount(): void
    {
        $this->connector->send(new UnmountVirtio($this->vmId));
    }
}
