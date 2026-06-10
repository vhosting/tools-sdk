<?php

namespace VHosting\ToolsSdk;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\Paginator;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use VHosting\ToolsSdk\Resources\ProxmoxResource;
use VHosting\ToolsSdk\Resources\WorkflowResource;

class ToolsConnector extends Connector implements HasPagination
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;
    
    protected static ?string $locale = null;
    
    public function __construct(
        protected readonly string $apiKey,
        protected readonly string $baseUrl = 'https://tools.vhosting-it.com/',
        protected readonly array $guzzleOptions = [],
    ) {
    }
    
    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }
    
    protected function defaultAuth(): ?Authenticator
    {
        return new TokenAuthenticator($this->apiKey);
    }
    
    public static function setLocale(string $locale): void
    {
        self::$locale = $locale;
    }
    
    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Locale' => self::$locale ?? 'en',
        ];
    }
    
    public function defaultConfig(): array
    {
        return $this->guzzleOptions;
    }
    
    public function paginate(Request $request): Paginator
    {
        return new LaravelResourcePaginator($this, $request);
    }
    
    public function workflow(): WorkflowResource
    {
        return new WorkflowResource($this);
    }
    
    public function proxmox(): ProxmoxResource
    {
        return new ProxmoxResource($this);
    }
}