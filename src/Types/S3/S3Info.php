<?php

namespace VHosting\ToolsSdk\Types\S3;

use Carbon\CarbonImmutable;

class S3Info
{
    public function __construct(
        public int $id,
        public string $user,
        public string $tenant,
        public string $access_key,
        public string $secret_key,
        public S3ProductStatus $product_status,
        public CarbonImmutable $created_at,
        public CarbonImmutable $updated_at,
    ) {
    }
}