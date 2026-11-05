<?php

namespace VHosting\ToolsSdk\Resources;

use Saloon\Http\Connector;
use VHosting\ToolsSdk\Requests\Proxmox\Kickstart\DeleteKickstart;
use VHosting\ToolsSdk\Requests\Proxmox\Kickstart\GetKickstart;
use VHosting\ToolsSdk\Requests\Proxmox\Kickstart\UpsertKickstart;
use VHosting\ToolsSdk\Types\Proxmox\Kickstart;
use VHosting\ToolsSdk\Types\Proxmox\KickstartType;

class ProxmoxVmKickstartResource
{
    public function __construct(protected readonly Connector $connector, protected readonly int $vmId)
    {
    }

    public function show(): Kickstart
    {
        return $this->connector->send(new GetKickstart($this->vmId))->dto();
    }

    public function upsert(bool $enabled, KickstartType $type, string $content): Kickstart
    {
        return $this->connector->send(new UpsertKickstart($this->vmId, $enabled, $type, $content))->dto();
    }

    public function destroy(): void
    {
        $this->connector->send(new DeleteKickstart($this->vmId));
    }
}
