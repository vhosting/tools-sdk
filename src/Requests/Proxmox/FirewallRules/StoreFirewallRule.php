<?php

namespace VHosting\ToolsSdk\Requests\Proxmox\FirewallRules;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class StoreFirewallRule extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected readonly int $vmId,
        protected readonly array $rule,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/api/proxmox/vm/%d/firewall/rules', $this->vmId);
    }

    protected function defaultBody(): array
    {
        return $this->rule;
    }
}
