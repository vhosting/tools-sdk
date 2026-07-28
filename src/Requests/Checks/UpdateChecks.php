<?php

namespace VHosting\ToolsSdk\Requests\Checks;

use Saloon\Contracts\Body\BodyRepository;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateChecks extends Request implements HasBody
{
    use HasJsonBody;
    
    protected Method $method = Method::POST;
    
    /**
     * @param int $domainId
     * @param array{id:string,result:int}[] $data
     */
    public function __construct(protected int $domainId, protected array $data = [])
    {
    }
    
    public function resolveEndpoint(): string
    {
        return '/api/checks';
    }
    
    protected function defaultBody(): array
    {
        return [
            'id' => $this->domainId,
            'data' => $this->data,
        ];
    }
}