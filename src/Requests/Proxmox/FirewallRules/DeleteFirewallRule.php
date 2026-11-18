<?php

namespace VHosting\ToolsSdk\Requests\Proxmox\FirewallRules;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteFirewallRule extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected readonly int $vmId,
        protected readonly int $pos,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/api/proxmox/vm/%d/firewall/rules/%d', $this->vmId, $this->pos);
    }
}
