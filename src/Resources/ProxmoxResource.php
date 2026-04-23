<?php

namespace VHosting\ToolsSdk\Resources;

use Saloon\Http\BaseResource;
use VHosting\ToolsSdk\Requests\Proxmox\GetVm;
use VHosting\ToolsSdk\Types\ProxmoxVm;

class ProxmoxResource extends BaseResource
{
    public function getVm(int $id): ProxmoxVm
    {
        return $this->connector->send(new GetVm($id))->dto();
    }
}
