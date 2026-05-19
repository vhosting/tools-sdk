<?php

namespace VHosting\ToolsSdk\Types;

enum ProxmoxIpType: string
{
    case IPv4 = 'ipv4';
    case IPv6 = 'ipv6';
}
