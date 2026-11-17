<?php

namespace VHosting\ToolsSdk\Requests\Proxmox;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\Proxmox\FirewallIpset;

class GetVmFirewallIpset extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected readonly int $id, protected readonly string $ipset)
    {
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/api/proxmox/vm/%d/firewall/ipset/%s', $this->id, rawurlencode($this->ipset));
    }

    /**
     * @return FirewallIpset[]
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(function (array $item) {
            $data = fluent($item);

            return new FirewallIpset(
                cidr: $data->string('cidr'),
                comment: $data->string('comment'),
            );
        }, $response->json());
    }
}
