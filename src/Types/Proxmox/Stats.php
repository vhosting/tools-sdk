<?php

namespace VHosting\ToolsSdk\Types\Proxmox;

use Carbon\Carbon;

class Stats
{
    public function __construct(
        public Carbon $time,
        
        public float $cpu,
        public int $maxcpu,
        
        public int $disk,
        public int $maxdisk,
        public float $diskread,
        public float $diskwrite,
        
        public float $mem,
        public int $maxmem,
        
        public float $netin,
        public float $netout,
    ) {
    }
}