<?php

use PHPUnit\Framework\TestCase;
use Saloon\Enums\Method;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VHosting\ToolsSdk\ToolsConnector;
use VHosting\ToolsSdk\Types\Proxmox\KickstartType;

class ProxmoxVmKickstartTest extends TestCase
{
    public function test_show_maps_all_documented_types_and_preserves_content(): void
    {
        foreach (['rehl', 'ubuntu-autoinstall', 'debian-installer-preesed'] as $type) {
            $payload = ['enabled' => false, 'type' => $type, 'content' => "# config\n  value: test\n"];
            $mock = new MockClient([MockResponse::make($payload)]);
            $connector = (new ToolsConnector('test-token'))->withMockClient($mock);

            $kickstart = $connector->proxmox()->vm(123)->kickstart()->show();

            $this->assertFalse($kickstart->enabled);
            $this->assertSame(KickstartType::from($type), $kickstart->type);
            $this->assertSame($payload, $kickstart->toArray());
            $this->assertSame(Method::GET, $mock->getLastPendingRequest()->getMethod());
            $this->assertSame('https://tools.vhosting-it.com/api/proxmox/vm/123/kickstart', $mock->getLastPendingRequest()->getUrl());
        }
    }

    public function test_upsert_sends_json_and_maps_both_success_statuses(): void
    {
        foreach ([200, 201] as $status) {
            $payload = ['enabled' => true, 'type' => 'ubuntu-autoinstall', 'content' => "#cloud-config\nautoinstall:\n  version: 1\n"];
            $mock = new MockClient([MockResponse::make($payload, $status)]);
            $connector = (new ToolsConnector('test-token'))->withMockClient($mock);

            $kickstart = $connector->proxmox()->vm(123)->kickstart()->upsert(
                enabled: true,
                type: KickstartType::UbuntuAutoInstall,
                content: $payload['content'],
            );

            $this->assertSame($payload, $kickstart->toArray());
            $request = $mock->getLastPendingRequest();
            $this->assertSame(Method::PATCH, $request->getMethod());
            $this->assertSame('/api/proxmox/vm/123/kickstart', $request->getRequest()->resolveEndpoint());
            $this->assertSame($payload, json_decode((string) $request->body(), true, flags: JSON_THROW_ON_ERROR));
        }
    }

    public function test_upsert_sends_all_fields_and_preserves_false(): void
    {
        $payload = ['enabled' => false, 'type' => 'rehl', 'content' => 'existing configuration'];
        $mock = new MockClient([MockResponse::make($payload)]);
        $connector = (new ToolsConnector('test-token'))->withMockClient($mock);

        $kickstart = $connector->proxmox()->vm(123)->kickstart()->upsert(
            enabled: false,
            type: KickstartType::RhelKickStart,
            content: $payload['content'],
        );

        $this->assertSame($payload, $mock->getLastPendingRequest()->body()->all());
        $this->assertSame($payload, $kickstart->toArray());
    }

    public function test_upsert_rejects_missing_fields_before_sending_a_request(): void
    {
        $mock = new MockClient();
        $connector = (new ToolsConnector('test-token'))->withMockClient($mock);

        try {
            $connector->proxmox()->vm(123)->kickstart()->upsert(enabled: false);
            $this->fail('Upsert accepted missing fields.');
        } catch (ArgumentCountError) {
            $mock->assertNothingSent();
        }
    }

    public function test_destroy_accepts_no_content(): void
    {
        $mock = new MockClient([MockResponse::make(status: 204)]);
        $connector = (new ToolsConnector('test-token'))->withMockClient($mock);

        $this->assertNull($connector->proxmox()->vm(123)->kickstart()->destroy());
        $this->assertSame(Method::DELETE, $mock->getLastPendingRequest()->getMethod());
        $this->assertSame('/api/proxmox/vm/123/kickstart', $mock->getLastRequest()->resolveEndpoint());
    }

    public function test_missing_configuration_throws_the_api_error(): void
    {
        $mock = new MockClient([MockResponse::make(['message' => 'Not found'], 404)]);
        $connector = (new ToolsConnector('test-token'))->withMockClient($mock);

        $this->expectException(RequestException::class);

        $connector->proxmox()->vm(123)->kickstart()->show();
    }

    public function test_invalid_content_throws_the_api_validation_error(): void
    {
        $mock = new MockClient([MockResponse::make(['message' => 'The content field is required.'], 422)]);
        $connector = (new ToolsConnector('test-token'))->withMockClient($mock);

        $this->expectException(RequestException::class);

        $connector->proxmox()->vm(123)->kickstart()->upsert(
            enabled: true,
            type: KickstartType::UbuntuAutoInstall,
            content: '',
        );
    }
}
