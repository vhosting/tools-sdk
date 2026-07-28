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
     * @param array{id:string,result:int}[] $data
     */
    public function __construct(protected array $data = [])
    {
    }
    
    public function resolveEndpoint(): string
    {
        return '/api/checks';
    }
    
    protected function defaultBody(): array
    {
        return [
            'data' => $this->data,
        ];
    }
}