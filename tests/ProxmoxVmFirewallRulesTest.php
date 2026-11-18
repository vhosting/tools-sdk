<?php

use PHPUnit\Framework\TestCase;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use VHosting\ToolsSdk\Mocks;
use VHosting\ToolsSdk\ToolsConnector;

class ProxmoxVmFirewallRulesTest extends TestCase
{
    public function test_rule_operations_send_the_documented_requests(): void
    {
        $mock = new MockClient([Mocks::noContent(), Mocks::noContent(), Mocks::noContent()]);
        $connector = (new ToolsConnector('test-token'))->withMockClient($mock);
        $rules = $connector->proxmox()->vm(123)->firewallRules();
        $endpoint = '/api/proxmox/vm/123/firewall/rules';

        $rule = ['type' => 'in', 'action' => 'ACCEPT', 'proto' => 'tcp', 'dport' => '443'];
        $rules->store($rule);
        $request = $mock->getLastPendingRequest();
        $this->assertSame(Method::POST, $request->getMethod());
        $this->assertSame($endpoint, $request->getRequest()->resolveEndpoint());
        $this->assertSame($rule, $request->body()->all());

        $changes = ['enable' => 0, 'comment' => ''];
        $rules->update(0, $changes);
        $request = $mock->getLastPendingRequest();
        $this->assertSame(Method::PUT, $request->getMethod());
        $this->assertSame($endpoint.'/0', $request->getRequest()->resolveEndpoint());
        $this->assertSame($changes, $request->body()->all());

        $rules->destroy(2);
        $request = $mock->getLastPendingRequest();
        $this->assertSame(Method::DELETE, $request->getMethod());
        $this->assertSame($endpoint.'/2', $request->getRequest()->resolveEndpoint());
    }
}
