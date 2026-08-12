<?php

namespace VHosting\ToolsSdk\Types\S3;

enum S3ProductStatus: string
{
    case Active = 'active';
    case Suspended = 'suspended';
}