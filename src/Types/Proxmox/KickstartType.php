<?php

namespace VHosting\ToolsSdk\Types\Proxmox;

enum KickstartType: string
{
    case RhelKickStart = 'rehl-kickstart';
    case UbuntuAutoInstall = 'ubuntu-autoinstall';
    case DebianInstallerPreseed = 'debian-installer-preesed';
    
    public function label(): string
    {
        return match($this){
            self::RhelKickStart => 'RHEL KickStart',
            self::UbuntuAutoInstall => 'Ubuntu AutoInstall',
            self::DebianInstallerPreseed => 'Debian Installer Preseed',
        };
    }
}
