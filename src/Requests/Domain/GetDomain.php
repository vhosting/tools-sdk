<?php

namespace VHosting\ToolsSdk\Requests\Domain;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use VHosting\ToolsSdk\Types\Domain\Domain;
use VHosting\ToolsSdk\Types\Domain\DomainCheck;
use VHosting\ToolsSdk\Types\ProxmoxVm;

class GetDomain extends Request
{
    protected Method $method = Method::GET;
    
    public function __construct(public readonly string $name)
    {
    }
    
    public function resolveEndpoint(): string
    {
        return '/api/email/domain/find';
    }
    
    protected function defaultQuery(): array
    {
        return [
            'name' => $this->name,
        ];
    }
    
    public function createDtoFromResponse(Response $response): Domain
    {
        $data = fluent($response->json());
        
        return new Domain(
            id: $data->integer('id'),
            name: $data->get('name'),
            web_server_id: $data->get('web_server_id'),
            dkim: $data->get('dkim'),
            mail_server: $data->get('mail_server'),
            autodiscover: $data->get('autodiscover'),
            created_at: $data->date('created_at')?->toImmutable(),
            updated_at: $data->date('updated_at')?->toImmutable(),
            locked_at: $data->date('locked_at')?->toImmutable(),
            checked_at: $data->date('checked_at')?->toImmutable(),
            checks: $data->missing('checks')
                ? null
                : $data->collect('checks')->map(fn($check) => new DomainCheck(
                    id: $check['id'],
                    domain_id: $check['domain_id'],
                    type: $check['type'],
                    result: $check['result'],
                    short: $check['short'],
                    label: $check['label'],
                )),
        );
    }
}
