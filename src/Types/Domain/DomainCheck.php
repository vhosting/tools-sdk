<?php

namespace VHosting\ToolsSdk\Types\Domain;

use VHosting\ToolsSdk\Types\BaseType;

class DomainCheck extends BaseType
{
    public function __construct(
        public readonly int $id,
        public readonly int $domain_id,
        public readonly string $type,
        public readonly bool $result,
        public readonly string $short,
        public readonly string $label,
    ) {
    }
}