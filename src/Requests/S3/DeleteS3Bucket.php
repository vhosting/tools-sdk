<?php

namespace VHosting\ToolsSdk\Requests\S3;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteS3Bucket extends Request
{
    protected Method $method = Method::DELETE;
    
    public function __construct(public int $id, public string $name)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf('/api/s3/%d/buckets/%s', $this->id, $this->name);
    }
}