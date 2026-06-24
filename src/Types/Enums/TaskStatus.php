<?php

namespace VHosting\ToolsSdk\Types\Enums;

enum TaskStatus: string
{
    case Pending = 'pending';
    case Progress = 'progress';
    case Completed = 'completed';
}
