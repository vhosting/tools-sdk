<?php

namespace VHosting\ToolsSdk\Requests\S3;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\S3\S3Bucket;
use VHosting\ToolsSdk\Types\S3\S3Buckets;

class GetS3Buckets extends Request
{
    protected Method $method = Method::GET;
    
    public function __construct(public int $id)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf('/api/s3/%d/buckets', $this->id);
    }
    
    public function createDtoFromResponse(Response $response): S3Buckets
    {
        $data = fluent($response->json());
        
        return new S3Buckets(
            quota: $data->integer('quota'),
            buckets: $data->collect('buckets')->map(function (array $bucket) {
                $data = fluent($bucket);
                
                return new S3Bucket(
                    name: $data->string('name'),
                    creationDate: $data->date('creation_date')->toImmutable(),
                    used: $data->integer('used'),
                    objects: $data->integer('objects'),
                );
            })->all(),
        );
    }
}