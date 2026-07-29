<?php

namespace VHosting\ToolsSdk\Types;

use Carbon\Carbon;
use VHosting\ToolsSdk\Types\Enums\ServerPanel;

class Server extends BaseType
{
    public function __construct(
        public int $id,
        public string $name,
        public string $ip4,
        public ?string $ip6,
        public ServerPanel $panel,
        public ?string $auth_key,
        public ?Carbon $created_at,
        public ?Carbon $updated_at,
    ) {
    
    }
}