<?php

namespace VHosting\ToolsSdk\Resources;

use Saloon\Http\BaseResource;
use VHosting\ToolsSdk\Requests\Proxmox\GetPlans;

class ProxmoxResource extends BaseResource
{
    public function plans(): array
    {
        return $this->connector->send(new GetPlans())->dto();
    }
    
    public function vm(int $id): ProxmoxVmResource
    {
        return new ProxmoxVmResource($this->connector, $id);
    }
}
