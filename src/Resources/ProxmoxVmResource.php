<?php

namespace VHosting\ToolsSdk\Resources;

use Saloon\Http\Connector;
use VHosting\ToolsSdk\Requests\Proxmox\GetVm;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmBackups;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmIps;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmRdns;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmStats;
use VHosting\ToolsSdk\Requests\Proxmox\OpenVncProxy;
use VHosting\ToolsSdk\Types\Proxmox\Rdns;
use VHosting\ToolsSdk\Types\Proxmox\Stats;
use VHosting\ToolsSdk\Types\Proxmox\StatsTimeframe;
use VHosting\ToolsSdk\Types\Proxmox\VncProxy;
use VHosting\ToolsSdk\Types\ProxmoxBackup;
use VHosting\ToolsSdk\Types\ProxmoxIp;
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
    
    /**
     * @return ProxmoxIp[]
     */
    public function ips(): array
    {
        return $this->connector->send(new GetVmIps($this->id))->dto();
    }
    
    /**
     * @return ProxmoxBackup[]
     */
    public function backups(): array
    {
        return $this->connector->send(new GetVmBackups($this->id))->dto();
    }
    
    public function openVncProxy(): VncProxy
    {
        return $this->connector->send(new OpenVncProxy($this->id))->dto();
    }
    
    /**
     * @return Stats[]
     */
    public function stats(StatsTimeframe $timeframe): array
    {
        return $this->connector->send(new GetVmStats($this->id, $timeframe))->dto();
    }
    
    /**
     * @return Rdns[]
     */
    public function rdns(): array
    {
        return $this->connector->send(new GetVmRdns($this->id))->dto();
    }
    
    public function iso(): ProxmoxVmIsoResource
    {
        return new ProxmoxVmIsoResource($this->connector, $this->id);
    }
}
