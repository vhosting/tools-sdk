<?php

namespace VHosting\ToolsSdk\Types\Domain;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

readonly class Domain
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
        public int $id,
        public string $name,
        public ?int $web_server_id,
        public string $dkim,
        public string $mail_server,
        public string $autodiscover,
        public ?CarbonImmutable $created_at,
        public ?CarbonImmutable $updated_at,
        public ?CarbonImmutable $locked_at,
        public ?CarbonImmutable $checked_at,
        public ?Collection $checks,
    )
    {
    }
}