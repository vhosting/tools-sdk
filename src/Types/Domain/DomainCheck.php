<?php

namespace VHosting\ToolsSdk\Types\Domain;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

readonly class DomainCheck
{
    public function __construct(
        public int $id,
        public int $domain_id,
        public string $type,
        public bool $result,
        public string $short,
        public string $label,
    ) {
    }
}