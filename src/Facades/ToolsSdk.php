<?php

namespace VHosting\ToolsSdk\Facades;

use Illuminate\Support\Facades\Facade;
use Saloon\Laravel\Facades\Saloon;
use VHosting\ToolsSdk\Resources\WorkflowResource;

/**
 * @method static WorkflowResource workflow()
 * @see \VHosting\ToolsSdk\ToolsConnector
 */
class ToolsSdk extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'tools-sdk';
    }
    
    public static function fake(array $responses): void
    {
        config(['tools-sdk.mock' => false]);
        
        Saloon::fake($responses);
    }
}