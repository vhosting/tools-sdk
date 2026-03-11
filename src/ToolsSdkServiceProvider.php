<?php

namespace VHosting\ToolsSdk;

use Illuminate\Support\ServiceProvider;
use Saloon\Http\Faking\MockClient;
use VHosting\ToolsSdk\Requests\DispatchWorkflow;
use VHosting\ToolsSdk\Requests\GetWorkflow;
use VHosting\ToolsSdk\Requests\GetWorkflows;
use VHosting\ToolsSdk\Requests\RetryWorkflow;

class ToolsSdkServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/tools-sdk.php', 'tools-sdk');
        
        $this->app->bind('tools-sdk', function () {
            $connector = new ToolsConnector(
                apiKey: config('tools-sdk.token'),
                baseUrl: config('tools-sdk.url'),
            );
            
            if(config('tools-sdk.mock')){
                $mockClient = new MockClient([
                    GetWorkflows::class => Mocks::emptyArray(),
                    GetWorkflow::class => Mocks::workflow(),
                    RetryWorkflow::class => Mocks::noContent(),
                    DispatchWorkflow::class => Mocks::workflow(201),
                ]);
                
                $connector->withMockClient($mockClient);
            }
            
            return $connector;
        });
    }
}