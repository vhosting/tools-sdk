<?php

namespace VHosting\ToolsSdk\Requests\Proxmox;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class SetVmFirewallOptions extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(
        protected readonly int $vmId,
        protected readonly array $options,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/api/proxmox/vm/%d/firewall/options', $this->vmId);
    }

    protected function defaultBody(): array
    {
        return $this->options;
    }
}
