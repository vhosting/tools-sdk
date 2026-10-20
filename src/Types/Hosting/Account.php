<?php

namespace VHosting\ToolsSdk\Types\Hosting;

use VHosting\ToolsSdk\Types\BaseType;

class Account extends BaseType
{
    public function __construct(
        public string $product_status,
        public string $domain,
        public array $data = [],
    ) {
    
    }
}