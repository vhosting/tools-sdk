<?php

namespace VHosting\ToolsSdk;

use Illuminate\Support\ServiceProvider;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\PendingRequest;
use VHosting\ToolsSdk\Requests\Proxmox\GetPlans;
use VHosting\ToolsSdk\Requests\Proxmox\GetVm;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmBackups;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmIps;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmRdns;
use VHosting\ToolsSdk\Requests\Proxmox\GetVmStats;
use VHosting\ToolsSdk\Requests\Proxmox\Iso\{CheckIsoMounted, GetIsoList, MountIso, UnmountIso};
use VHosting\ToolsSdk\Requests\Proxmox\Virtio\{CheckVirtioMounted, GetVirtioList, MountVirtio, UnmountVirtio};
use VHosting\ToolsSdk\Requests\Proxmox\OpenVncProxy;
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
        
        $this->app->bind('tools-sdk', function () {
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
                    GetVmBackups::class => Mocks::emptyArray(),
                    GetVmIps::class => Mocks::emptyArray(),
                    GetVmRdns::class => Mocks::emptyArray(),
                    GetVmStats::class => Mocks::emptyArray(),
                    OpenVncProxy::class => Mocks::noContent(),
                    
                    // task
                    CreateTask::class => Mocks::noContent(),
                    
                    // workflow
                    DispatchWorkflow::class => Mocks::workflow(201),
                    GetWorkflow::class => Mocks::workflow(),
                    GetWorkflows::class => Mocks::emptyPagination(),
                    RetryWorkflow::class => Mocks::noContent(),
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