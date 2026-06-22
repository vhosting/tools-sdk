<?php

namespace VHosting\ToolsSdk\Types;

class ProxmoxBackup extends BaseType
{
    public function __construct(
        public string $size,
        public string $created,
    ) {
    }
}