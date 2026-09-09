<?php

namespace VHosting\ToolsSdk\Types\Domain;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use VHosting\ToolsSdk\Types\BaseType;

class Domain extends BaseType
{
    /**
     * @param int $id
     * @param string $name
     * @param int|null $web_server_id
     * @param string $dkim
     * @param string $mail_server
     * @param string $autodiscover
     * @param CarbonImmutable|null $created_at
     * @param CarbonImmutable|null $updated_at
     * @param CarbonImmutable|null $locked_at
     * @param CarbonImmutable|null $checked_at
     * @param Collection<DomainCheck>|null $checks
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?int $web_server_id,
        public readonly string $dkim,
        public readonly string $mail_server,
        public readonly string $autodiscover,
        public readonly ?CarbonImmutable $created_at,
        public readonly ?CarbonImmutable $updated_at,
        public readonly ?CarbonImmutable $locked_at,
        public readonly ?CarbonImmutable $checked_at,
        public readonly ?Collection $checks,
    )
    {
    }
}