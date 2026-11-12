<?php

namespace VHosting\ToolsSdk\Requests\Proxmox;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\Proxmox\Firewall;
use VHosting\ToolsSdk\Types\Proxmox\FirewallOption;
use VHosting\ToolsSdk\Types\Proxmox\FirewallRule;

class GetVmFirewall extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected readonly int $id)
    {
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/api/proxmox/vm/%d/firewall', $this->id);
    }

    public function createDtoFromResponse(Response $response): Firewall
    {
        $data = fluent($response->json());

        return new Firewall(
            rules: $data->collect('rules')->map(function (array $rule) {
                $data = fluent($rule);

                return new FirewallRule(
                    source: $data->get('source'),
                    enable: $data->boolean('enable'),
                    action: $data->string('action'),
                    type: $data->string('type'),
                );
            })->all(),
            ipset: $data->array('ipset'),
            options: $data->collect('options')->map(function (array $option) {
                $data = fluent($option);

                return new FirewallOption(
                    option: $data->string('option'),
                    value: $data->string('value'),
                );
            })->all(),
        );
    }
}
