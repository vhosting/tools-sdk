<?php

namespace VHosting\ToolsSdk\Facades;

use Illuminate\Support\Facades\Facade;
use Saloon\Laravel\Facades\Saloon;
use VHosting\ToolsSdk\Resources\ProxmoxResource;
use VHosting\ToolsSdk\Resources\WorkflowResource;
use VHosting\ToolsSdk\ToolsConnector;

/**
 * @method static WorkflowResource workflow()
 * @method static ProxmoxResource proxmox()
 * @see \VHosting\ToolsSdk\ToolsConnector
 */
class ToolsSdk extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ToolsConnector::class;
    }
    
    public static function fake(array $responses): void
    {
        config(['tools-sdk.mock' => false]);
        
        Saloon::fake($responses);
    }
}