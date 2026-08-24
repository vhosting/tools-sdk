<?php

namespace VHosting\ToolsSdk;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\PendingRequest;
use VHosting\ToolsSdk\Requests\Checks\UpdateChecks;
use VHosting\ToolsSdk\Requests\Proxmox\GetPlans;
use VHosting\ToolsSdk\Requests\Proxmox\GetVm;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmBackups;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmIps;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmRdns;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmSnapshots;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmStats;
use VHosting\ToolsSdk\Requests\Proxmox\Iso\{CheckIsoMounted, GetIsoList, MountIso, UnmountIso};
use VHosting\ToolsSdk\Requests\Proxmox\Virtio\{CheckVirtioMounted, GetVirtioList, MountVirtio, UnmountVirtio};
use VHosting\ToolsSdk\Requests\Proxmox\OpenVncProxy;
use VHosting\ToolsSdk\Requests\S3\CreateS3Bucket;
use VHosting\ToolsSdk\Requests\S3\DeleteS3Bucket;
use VHosting\ToolsSdk\Requests\S3\GetS3Buckets;
use VHosting\ToolsSdk\Requests\S3\GetS3Info;
use VHosting\ToolsSdk\Requests\Servers\GetServers;
use VHosting\ToolsSdk\Requests\Task\CreateTask;
use VHosting\ToolsSdk\Requests\Workflow\DispatchWorkflow;
use VHosting\ToolsSdk\Requests\Workflow\GetWorkflow;
use VHosting\ToolsSdk\Requests\Workflow\GetWorkflows;
use VHosting\ToolsSdk\Requests\Workflow\RetryWorkflow;

class ToolsSdkServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/tools-sdk.php', 'tools-sdk');
        
        $this->app->bind(ToolsConnector::class, function () {
            $connector = new ToolsConnector(
                apiKey: config('tools-sdk.token'),
                baseUrl: config('tools-sdk.url'),
                guzzleOptions: config('tools-sdk.guzzle_options'),
            );
            
            if(config('tools-sdk.mock')){
                $mockClient = new MockClient([
                    // promox.iso
                    CheckIsoMounted::class => Mocks::custom(['mounted' => true, 'iso' => 'Custom ISO name']),
                    GetIsoList::class => Mocks::emptyArray(),
                    MountIso::class => Mocks::noContent(),
                    UnmountIso::class => Mocks::noContent(),
                    
                    // promox.virtio
                    CheckVirtioMounted::class => Mocks::custom(['mounted' => true, 'iso' => 'Custom ISO name']),
                    GetVirtioList::class => Mocks::emptyArray(),
                    MountVirtio::class => Mocks::noContent(),
                    UnmountVirtio::class => Mocks::noContent(),
                    
                    // proxmox
                    GetPlans::class => Mocks::emptyArray(),
                    GetVm::class => fn (PendingRequest $request) => Mocks::vm($request),
                    GetVmBackups::class => Mocks::custom([
                        ['volid' => 'a', 'size' => '100 MB', 'created' => now()->toIso8601ZuluString()],
                        ['volid' => 'b', 'size' => '100 MB', 'created' => now()->toIso8601ZuluString()],
                        ['volid' => 'c', 'size' => '100 MB', 'created' => now()->toIso8601ZuluString()],
                    ]),
                    GetVmIps::class => Mocks::custom([
                        [
                            'id' => 1,
                            'cluster_id' => 2,
                            'plan_group_id' => 3,
                            'ip' => '58.65.9.8',
                            'cidr' => '24',
                            'gateway' => '58.65.9.1',
                            'bridge' => 'bridge',
                            'type' => 'ipv4',
                            'enabled' => true,
                            'note' => 'foo',
                            'reserved' => false,
                            'created_at' => now()->toIso8601ZuluString(),
                            'updated_at' => now()->toIso8601ZuluString(),
                        ]
                    ]),
                    GetVmRdns::class => Mocks::custom([
                        ['ip' => '192.168.1.1', 'hostname' => 'foo.tld'],
                        ['ip' => '192.168.1.2', 'hostname' => 'bar.tld'],
                        ['ip' => '192.168.1.3', 'hostname' => 'baz.tld'],
                    ]),
                    GetVmStats::class => Mocks::emptyArray(),
                    OpenVncProxy::class => Mocks::noContent(),
                    GetVmSnapshots::class => Mocks::custom([
                        [
                            'name' => Str::uuid7(),
                            'description' => 'foo',
                            'parent' => null,
                            'created_at' => now()->toIso8601ZuluString(),
                            'is_current' => true,
                        ],
                        [
                            'name' => Str::uuid7(),
                            'description' => 'bar',
                            'parent' => 'foo',
                            'created_at' => now()->toIso8601ZuluString(),
                            'is_current' => true,
                        ]
                    ]),
                    
                    // task
                    CreateTask::class => Mocks::noContent(),
                    
                    // workflow
                    DispatchWorkflow::class => Mocks::workflow(201),
                    GetWorkflow::class => Mocks::workflow(),
                    GetWorkflows::class => Mocks::emptyPagination(),
                    RetryWorkflow::class => Mocks::noContent(),
                    
                    // checks
                    UpdateChecks::class => Mocks::noContent(),
                    
                    // server
                    GetServers::class => Mocks::emptyArray(),
                    
                     //s3
                    GetS3Info::class => fn (PendingRequest $request) =>  Mocks::s3($request),
                    GetS3Buckets::class => Mocks::s3Buckets(),
                    CreateS3Bucket::class => Mocks::noContent(),
                    DeleteS3Bucket::class => Mocks::noContent(),
                ]);
                
                $connector->withMockClient($mockClient);
            }
            
            return $connector;
        });
    }
    
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/tools-sdk.php' => config_path('tools-sdk.php'),
        ], 'tools-sdk');
    }
}