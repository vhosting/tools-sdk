<?php

namespace VHosting\ToolsSdk\Requests\Proxmox;

use Carbon\Carbon;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\Proxmox\Stats;
use VHosting\ToolsSdk\Types\Proxmox\StatsTimeframe;
use VHosting\ToolsSdk\Types\ProxmoxBackup;
use VHosting\ToolsSdk\Types\ProxmoxIp;
use VHosting\ToolsSdk\Types\ProxmoxIpType;
use VHosting\ToolsSdk\Types\ProxmoxPlan;
use VHosting\ToolsSdk\Types\ProxmoxVm;

class GetVmStats extends Request
{
    protected Method $method = Method::GET;
    
    public function __construct(protected readonly int $id, protected StatsTimeframe $timeframe)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf("/api/proxmox/vm/%d/stats", $this->id);
    }
    
    protected function defaultQuery(): array
    {
        return [
            'timeframe' => $this->timeframe->value,
        ];
    }
    
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(function (array $item){
            $data = fluent($item);
        
            return new Stats(
                time: Carbon::createFromTimestamp($data->integer('time')),
                cpu: $data->float('cpu'),
                maxcpu: $data->integer('maxcpu'),
                disk: $data->integer('disk'),
                maxdisk: $data->integer('maxdisk'),
                diskread: $data->float('diskread'),
                diskwrite: $data->float('diskwrite'),
                mem: $data->float('mem'),
                maxmem: $data->integer('maxmem'),
                netin: $data->float('netin'),
                netout: $data->float('netout'),
            );
            
        }, $response->json());
    }
}
