<?php

namespace VHosting\ToolsSdk\Resources;

use Saloon\Http\Connector;
use VHosting\ToolsSdk\Requests\Domain\GetDomain;
use VHosting\ToolsSdk\Types\Domain\Domain;

class DomainResource
{
    public function __construct(protected readonly Connector $connector)
    {
    }
    
    public function find(string $name): Domain
    {
        return $this->connector->send(new GetDomain($name))->dto();
    }
}