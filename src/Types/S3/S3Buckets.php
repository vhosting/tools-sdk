<?php

namespace VHosting\ToolsSdk\Types\S3;

use Carbon\CarbonImmutable;

class S3Buckets
{
    /**
     * @param int $quota
     * @param S3Bucket[] $buckets
     */
    public function __construct(
        public int $quota,
        public array $buckets,
    )
    {
    }
}