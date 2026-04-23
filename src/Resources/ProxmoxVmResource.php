<?php

namespace VHosting\ToolsSdk\Resources;

use Saloon\Http\BaseResource;
use VHosting\ToolsSdk\Requests\ProxmoxVm\GetVm;
use VHosting\ToolsSdk\Types\ProxmoxVm;

class ProxmoxVmResource extends BaseResource
{
    public function get(int $id): ProxmoxVm
    {
        return $this->connector->send(new GetVm($id))->dto();
    }
}
