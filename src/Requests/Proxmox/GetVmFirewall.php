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
                    pos: $data->integer('pos'),
                    enabled: $data->boolean('enabled'),
                    type: $data->string('type'),
                    action: $data->string('action'),
                    proto: $data->string('proto'),
                    source: $data->get('source'),
                    sport: $data->string('sport'),
                    dest: $data->string('dest'),
                    dport: $data->string('dport'),
                    comment: $data->string('comment'),
                );
            })->all(),
            ipset: $data->array('ipset'),
            options: $data->collect('options')->map(function (array $option) {
                $data = fluent($option);

                return new FirewallOption(
                    option: $data->string('option'),
                    label: $data->string('label'),
                    value: $data->string('value'),
                );
            })->all(),
        );
    }
}
