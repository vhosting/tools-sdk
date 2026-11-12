<?php

use PHPUnit\Framework\TestCase;
use Saloon\Enums\Method;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VHosting\ToolsSdk\ToolsConnector;
use VHosting\ToolsSdk\Types\Proxmox\Firewall;
use VHosting\ToolsSdk\Types\Proxmox\FirewallOption;
use VHosting\ToolsSdk\Types\Proxmox\FirewallRule;

class ProxmoxVmFirewallTest extends TestCase
{
    public function test_firewall_maps_the_documented_response_and_preserves_nullable_sources(): void
    {
        $payload = [
            'rules' => [
                ['source' => '192.0.2.0/24', 'enable' => true, 'action' => 'ACCEPT', 'type' => 'in'],
                ['source' => null, 'enable' => false, 'action' => 'DROP', 'type' => 'out'],
            ],
            'ipset' => ['192.0.2.1', '2001:db8::/64'],
            'options' => [
                ['option' => 'enable', 'value' => '0'],
                ['option' => 'policy_in', 'value' => 'DROP'],
            ],
        ];
        $mock = new MockClient([MockResponse::make($payload)]);
        $connector = (new ToolsConnector('test-token'))->withMockClient($mock);

        $firewall = $connector->proxmox()->vm(123)->firewall();

        $this->assertInstanceOf(Firewall::class, $firewall);
        $this->assertInstanceOf(FirewallRule::class, $firewall->rules[0]);
        $this->assertInstanceOf(FirewallOption::class, $firewall->options[0]);
        $this->assertTrue($firewall->rules[0]->enable);
        $this->assertFalse($firewall->rules[1]->enable);
        $this->assertNull($firewall->rules[1]->source);
        $this->assertSame($payload, $firewall->toArray());
        $request = $mock->getLastPendingRequest();
        $this->assertSame(Method::GET, $request->getMethod());
        $this->assertSame('https://tools.vhosting-it.com/api/proxmox/vm/123/firewall', $request->getUrl());
    }

    public function test_firewall_accepts_empty_lists(): void
    {
        $payload = ['rules' => [], 'ipset' => [], 'options' => []];
        $mock = new MockClient([MockResponse::make($payload)]);
        $connector = (new ToolsConnector('test-token'))->withMockClient($mock);

        $this->assertSame($payload, $connector->proxmox()->vm(456)->firewall()->toArray());
    }

    public function test_firewall_propagates_documented_api_errors(): void
    {
        foreach ([401, 403, 404] as $status) {
            $mock = new MockClient([MockResponse::make(['message' => 'API error'], $status)]);
            $connector = (new ToolsConnector('test-token'))->withMockClient($mock);

            try {
                $connector->proxmox()->vm(123)->firewall();
                $this->fail(sprintf('Firewall accepted an HTTP %d response.', $status));
            } catch (RequestException $exception) {
                $this->assertSame($status, $exception->getResponse()->status());
            }
        }
    }
}
