<?php

namespace VHosting\ToolsSdk\Resources;

use Saloon\Http\Connector;
use VHosting\ToolsSdk\Requests\OqmilterDedicated\GetCounter;
use VHosting\ToolsSdk\Requests\OqmilterDedicated\GetDkim;
use VHosting\ToolsSdk\Requests\OqmilterDedicated\GetLimit;
use VHosting\ToolsSdk\Requests\OqmilterDedicated\GetTimestamp;
use VHosting\ToolsSdk\Requests\Proxmox\Iso\CheckIsoMounted;
use VHosting\ToolsSdk\Requests\Proxmox\Iso\GetIsoList;
use VHosting\ToolsSdk\Requests\Proxmox\Iso\MountIso;
use VHosting\ToolsSdk\Requests\Proxmox\Iso\UnmountIso;
use VHosting\ToolsSdk\Types\Proxmox\Iso;
use VHosting\ToolsSdk\Types\Proxmox\MountedIso;

class OqmilterDedicatedResource
{
    public function __construct(protected readonly Connector $connector, protected readonly string $domain)
    {
    }
    
    public function counter(): int
    {
        return $this->connector->send(new GetCounter($this->domain))->dto();
    }
    
    public function limit(): int
    {
        return $this->connector->send(new GetLimit($this->domain))->dto();
    }
    
    public function dkim(): string
    {
        return $this->connector->send(new GetDkim($this->domain))->dto();
    }
    
    public function timestamp(): string
    {
        return $this->connector->send(new GetTimestamp($this->domain))->dto();
    }
}
