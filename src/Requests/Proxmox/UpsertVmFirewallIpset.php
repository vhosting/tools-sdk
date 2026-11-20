<?php

namespace VHosting\ToolsSdk\Requests\Proxmox;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpsertVmFirewallIpset extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(
        protected readonly int $vmId,
        protected readonly string $ipset,
        protected readonly array $options = [],
    ) {
        $this->body()->setJsonFlags(JSON_THROW_ON_ERROR | JSON_FORCE_OBJECT);
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/api/proxmox/vm/%d/firewall/ipset/%s', $this->vmId, rawurlencode($this->ipset));
    }

    protected function defaultBody(): array
    {
        return $this->options;
    }
}
