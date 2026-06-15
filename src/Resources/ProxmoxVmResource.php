<?php

namespace VHosting\ToolsSdk\Resources;

use Saloon\Http\Connector;
use VHosting\ToolsSdk\Requests\Proxmox\GetVm;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmBackups;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmIps;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmStats;
use VHosting\ToolsSdk\Requests\Proxmox\OpenVncProxy;
use VHosting\ToolsSdk\Types\Proxmox\StatsTimeframe;
use VHosting\ToolsSdk\Types\Proxmox\VncProxy;
use VHosting\ToolsSdk\Types\ProxmoxVm;

class ProxmoxVmResource
{
    public function __construct(protected readonly Connector $connector, protected readonly int $id)
    {
    }
    
    public function info(): ProxmoxVm
    {
        return $this->connector->send(new GetVm($this->id))->dto();
    }
    
    public function ips(): array
    {
        return $this->connector->send(new GetVmIps($this->id))->dto();
    }
    
    public function backups(): array
    {
        return $this->connector->send(new GetVmBackups($this->id))->dto();
    }
    
    public function openVncProxy(): VncProxy
    {
        return $this->connector->send(new OpenVncProxy($this->id))->dto();
    }
    
    public function stats(StatsTimeframe $timeframe): array
    {
        return $this->connector->send(new GetVmStats($this->id, $timeframe))->dto();
    }
}
