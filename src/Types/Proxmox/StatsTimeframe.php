<?php

namespace VHosting\ToolsSdk\Types\Proxmox;

enum StatsTimeframe: string
{
    case Hour = 'hour';
    case Day = 'day';
    case Week = 'week';
    case Month = 'month';
    case Year = 'year';
}
