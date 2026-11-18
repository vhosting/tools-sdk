<?php

namespace VHosting\ToolsSdk\Resources;

use Saloon\Http\Connector;
use VHosting\ToolsSdk\Requests\Proxmox\FirewallRules\DeleteFirewallRule;
use VHosting\ToolsSdk\Requests\Proxmox\FirewallRules\StoreFirewallRule;
use VHosting\ToolsSdk\Requests\Proxmox\FirewallRules\UpdateFirewallRule;

class ProxmoxVmFirewallRulesResource
{
    public function __construct(protected readonly Connector $connector, protected readonly int $vmId)
    {
    }

    /**
     * @param array<string, mixed> $rule
     */
    public function store(array $rule): void
    {
        $this->connector->send(new StoreFirewallRule($this->vmId, $rule));
    }

    /**
     * @param array<string, mixed> $rule
     */
    public function update(int $pos, array $rule): void
    {
        $this->connector->send(new UpdateFirewallRule($this->vmId, $pos, $rule));
    }

    public function destroy(int $pos): void
    {
        $this->connector->send(new DeleteFirewallRule($this->vmId, $pos));
    }
}
