<?php

use PHPUnit\Framework\TestCase;
use Saloon\Enums\Method;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VHosting\ToolsSdk\ToolsConnector;
use VHosting\ToolsSdk\Types\Proxmox\FirewallIpset;

class ProxmoxVmFirewallIpsetTest extends TestCase
{
    public function test_firewall_upsert_ipset_sends_optional_fields_to_the_named_set(): void
    {
        $mock = new MockClient([MockResponse::make('', 204), MockResponse::make('', 204)]);
        $vm = (new ToolsConnector('test-token'))->withMockClient($mock)->proxmox()->vm(123);

        $vm->firewallUpsertIpset('allowed');
        $this->assertSame('{}', (string) $mock->getLastPendingRequest()->body());

        $options = ['comment' => null, 'rename' => 'trusted'];
        $vm->firewallUpsertIpset('allowed/office', $options);
        $request = $mock->getLastPendingRequest();
        $this->assertSame(Method::PUT, $request->getMethod());
        $this->assertSame('https://tools.vhosting-it.com/api/proxmox/vm/123/firewall/ipset/allowed%2Foffice', $request->getUrl());
        $this->assertSame($options, $request->body()->all());
    }

    public function test_firewall_ipset_maps_the_documented_response(): void
    {
        $payload = [
            ['cidr' => '192.0.2.0/24', 'comment' => 'Allowed network'],
            ['cidr' => '2001:db8::/64', 'comment' => ''],
        ];
        $mock = new MockClient([MockResponse::make($payload)]);
        $connector = (new ToolsConnector('test-token'))->withMockClient($mock);

        $entries = $connector->proxmox()->vm(123)->firewallIpset('allowed');

        $this->assertCount(2, $entries);
        $this->assertContainsOnlyInstancesOf(FirewallIpset::class, $entries);
        $this->assertSame($payload, array_map(fn (FirewallIpset $entry) => $entry->toArray(), $entries));
        $request = $mock->getLastPendingRequest();
        $this->assertSame(Method::GET, $request->getMethod());
        $this->assertSame('https://tools.vhosting-it.com/api/proxmox/vm/123/firewall/ipset/allowed', $request->getUrl());
    }

    public function test_firewall_ipset_accepts_an_empty_list(): void
    {
        $mock = new MockClient([MockResponse::make([])]);
        $connector = (new ToolsConnector('test-token'))->withMockClient($mock);

        $this->assertSame([], $connector->proxmox()->vm(456)->firewallIpset('empty'));
    }

    public function test_firewall_ipset_encodes_the_name_as_a_path_segment(): void
    {
        $mock = new MockClient([MockResponse::make([])]);
        $connector = (new ToolsConnector('test-token'))->withMockClient($mock);

        $connector->proxmox()->vm(123)->firewallIpset('allowed /?#%');

        $this->assertSame(
            'https://tools.vhosting-it.com/api/proxmox/vm/123/firewall/ipset/allowed%20%2F%3F%23%25',
            $mock->getLastPendingRequest()->getUrl(),
        );
    }

    public function test_firewall_ipset_propagates_documented_api_errors(): void
    {
        foreach ([401, 403, 404] as $status) {
            $mock = new MockClient([MockResponse::make(['message' => 'API error'], $status)]);
            $connector = (new ToolsConnector('test-token'))->withMockClient($mock);

            try {
                $connector->proxmox()->vm(123)->firewallIpset('allowed');
                $this->fail(sprintf('Firewall IP set accepted an HTTP %d response.', $status));
            } catch (RequestException $exception) {
                $this->assertSame($status, $exception->getResponse()->status());
            }
        }
    }
}
