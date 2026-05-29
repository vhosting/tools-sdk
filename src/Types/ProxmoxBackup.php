<?php

namespace VHosting\ToolsSdk\Types;

class ProxmoxBackup
{
    public function __construct(
        public string $size,
        public string $created,
    ) {
    }
}