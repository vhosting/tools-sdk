<?php

namespace VHosting\ToolsSdk;

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;
use VHosting\ToolsSdk\Requests\Proxmox\GetVm;
use VHosting\ToolsSdk\Requests\S3\GetS3Buckets;
use VHosting\ToolsSdk\Requests\S3\GetS3Info;

class Mocks
{
    public static function noContent(): MockResponse
    {
        return MockResponse::make(status: 204);
    }
    
    public static function custom(array $data, int $status = 200): MockResponse
    {
        return MockResponse::make($data, $status);
    }
    
    public static function emptyArray(): MockResponse
    {
        return MockResponse::make([]);
    }
    
    public static function emptyPagination(): MockResponse
    {
        return MockResponse::make([
            'data' => [],
            'links' => [
                'next' => null,
            ]
        ]);
    }
    
    public static function workflow(int $status = 200): MockResponse
    {
        return MockResponse::make([
            'id' => 0,
            'type' => 'my-workflow',
            'description' => 'This is a mocked workflow.',
            'status' => 'completed',
            'payload' => [],
            'created_at' => '2026-03-09T13:46:51.000000Z',
            'updated_at' => '2026-03-09T13:49:19.000000Z',
            'tasks_count' => 1,
            'completed_tasks_count' => 1,
            'tasks' => [
                [
                    'id' => 0,
                    'workflow_id' => 0,
                    'description' => 'This is a mocked task.',
                    'order' => 1,
                    'status' => 'completed',
                    'error' => null,
                    'started_at' => '2026-03-09T13:47:37.000000Z',
                    'stopped_at' => '2026-03-09T13:47:37.000000Z',
                    'created_at' => '2026-03-09T13:46:51.000000Z',
                    'updated_at' => '2026-03-09T13:47:37.000000Z',
                ],
            ],
        ], $status);
    }
    
    public static function vm(PendingRequest $request): MockResponse
    {
        /** @var GetVm $request */
        $request = $request->getRequest();
        
        return MockResponse::make([
            'id' => $request->id,
            'type' => 'vm',
            'node_id' => 0,
            'plan_id' => 0,
            'hostname' => 'my-vm',
            'vm_status' => 'running',
            'product_status' => 'active',
            'phpmyadmin_url' => null,
            'dns1' => null,
            'dns2' => null,
            'ntp1' => null,
            'ntp2' => null,
            'created_at' => '2026-03-09T13:46:51.000000Z',
            'updated_at' => '2026-03-09T13:46:51.000000Z',
        ]);
    }
    
    public static function s3(PendingRequest $request): MockResponse
    {
        $request = $request->getRequest();
        /** @var GetS3Info $request */
        
        return MockResponse::make([
            'id' => $request->id,
            'user' => 'user123',
            'tenant' => 'tenant',
            'access_key' => 'ak123456789',
            'secret_key' => 'sk123456789',
            'product_status' => 'active',
            'created_at' => '2026-03-09T13:46:51.000000Z',
            'updated_at' => '2026-03-09T13:46:51.000000Z',
        ]);
    }
    
    public static function s3Buckets(): MockResponse
    {
        return MockResponse::make([
            'quota' => 1489621,
            'buckets' => [],
        ]);
    }
    
    public static function domain(): MockResponse
    {
        return MockResponse::make([
            'id' => 1,
            'name' => 'example.com',
            'web_server_id' => 2,
            'dkim' => 'dkim123',
            'mail_server' => 'mail.example.com',
            'autodiscover' => '127.0.0.1',
            'created_at' => now()->toImmutable(),
            'updated_at' => now()->toImmutable(),
            'locked_at' => null,
            'checked_at' => null,
            'checks' => [
                [
                    'id' => 3,
                    'domain_id' => 1,
                    'type' => 'dkim',
                    'result' => true,
                    'short' => 'DKIM',
                    'label' => 'DKIM',
                ],
            ],
        ]);
    }
}