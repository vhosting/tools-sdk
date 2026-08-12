<?php

namespace VHosting\ToolsSdk\Resources;

use Saloon\Http\Connector;
use VHosting\ToolsSdk\Requests\S3\GetS3Info;
use VHosting\ToolsSdk\Types\S3\S3Info;

class S3Resource
{
    public function __construct(protected readonly Connector $connector, protected readonly int $id)
    {
    }
    
    public function info(): S3Info
    {
        return $this->connector->send(new GetS3Info($this->id))->dto();
    }
}