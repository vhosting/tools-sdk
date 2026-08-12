<?php

namespace VHosting\ToolsSdk\Requests\S3;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\S3\S3Info;
use VHosting\ToolsSdk\Types\S3\S3ProductStatus;

class GetS3Info extends Request
{
    protected Method $method = Method::GET;
    
    public function __construct(public int $id)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return sprintf('/api/s3/%d', $this->id);
    }
    
    public function createDtoFromResponse(Response $response): S3Info
    {
        $data = fluent($response->json());
        
        return new S3Info(
            id: $data->integer('id'),
            user: $data->string('user'),
            tenant: $data->string('tenant'),
            access_key: $data->string('access_key'),
            secret_key: $data->string('secret_key'),
            product_status: $data->enum('product_status', S3ProductStatus::class),
            created_at: $data->date('created_at')?->toImmutable(),
            updated_at: $data->date('updated_at')?->toImmutable(),
        );
    }
}