<?php

namespace VHosting\ToolsSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Connector;
use VHosting\ToolsSdk\Requests\Proxmox\GetPlans;
use VHosting\ToolsSdk\Requests\Proxmox\GetVm;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmBackups;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmIps;
use VHosting\ToolsSdk\Requests\Proxmox\OpenVncProxy;
use VHosting\ToolsSdk\Types\Proxmox\VncProxy;
use VHosting\ToolsSdk\Types\ProxmoxVm;

class ProxmoxVmResource extends BaseResource
{
    public function __construct(protected readonly Connector $connector, protected readonly int $id)
    {
        parent::__construct($this->connector);
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
}
