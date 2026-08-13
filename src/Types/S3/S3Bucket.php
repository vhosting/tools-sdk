<?php

namespace VHosting\ToolsSdk\Types\S3;

use Carbon\CarbonImmutable;

class S3Bucket
{
    public function __construct(
        public string $name,
        public CarbonImmutable $creationDate,
        public int $used,
        public int $objects,
    )
    {
    }
}